<?php

namespace Submtd\EmailConfirmation\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Submtd\EmailConfirmation\Mail\ConfirmEmail;
use Submtd\EmailConfirmation\Events\EmailConfirmed;
use Submtd\EmailConfirmation\Events\FailedEmailConfirmation;
use Illuminate\Support\Facades\Request;

class ConfirmationController extends Controller
{
    protected $model;
    protected $redirectOnSuccess;
    protected $redirectOnFail;
    protected $redirectOnResend;

    public function __construct()
    {
        $this->model = config('auth.providers.users.model');
        $this->redirectOnSuccess = config('email-confirmation.redirectOnSuccess', '/');
        $this->redirectOnFail = config('email-confirmation.redirectOnFail', '/login');
        $this->redirectOnAlreadyConfirmed = config('email-confirmation.redirectOnAlreadyConfirmed', '/');
        $this->redirectOnResend = config('email-confirmation.redirectOnResend', '/login');
    }

    public function confirm($id, $token)
    {
        if (!$user = $this->model::find($id)) {
            Request::session()->flash('status', config('email-confirmation.statusMessages.invalidUserId', 'Invalid user id.'));
            return redirect($this->redirectOnFail);
        }
        if ($user->confirmed) {
            Request::session()->flash('status', config('email-confirmation.statusMessages.alreadyConfirmed', 'Your email has already been confirmed.'));
            return redirect($this->redirectOnAlreadyConfirmed);
        }
        if ($user->confirmation_token != $token) {
            event(new FailedEmailConfirmation($user));
            Request::session()->flash('status', config('email-confirmation.statusMessages.invalidToken', 'Invalid confirmation token.'))->error();
            return redirect($this->redirectOnFail);
        }
        $user->confirmation_token = null;
        $user->confirmed = true;
        $user->save();
        event(new EmailConfirmed($user));
        Auth::loginUsingId($user->id);
        Request::session()->flash('status', config('email-confirmation.statusMessages.confirmed', 'Your email address has been confirmed!'))->success();
        return redirect($this->redirectOnSuccess);
    }

    public function resend($id)
    {
        if (!$user = $this->model::find($id)) {
            Request::session()->flash('status', config('email-confirmation.statusMessages.invalidUserId', 'Invalid user id.'))->warning();
            return redirect()->back();
        }
        if ($user->confirmed) {
            Request::session()->flash('status', config('email-confirmation.statusMessages.alreadyConfirmed', 'Your email address has already been confirmed.'))->warning();
            return redirect()->back();
        }
        if (!$user->confirmation_token) {
            $user->confirmation_token = str_random(32);
            $user->save();
        }
        // todo: send confirmation email
        Mail::to($user)->queue(new ConfirmEmail($user));
        Request::session()->flash('status', config('email-confirmation.statusMessages.confirm', 'You must confirm your email address before logging in.'));
        return redirect($this->redirectOnResend);
    }
}
