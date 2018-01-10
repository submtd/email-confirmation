<?php

namespace Submtd\EmailConfirmation\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Submtd\EmailConfirmation\Mail\ConfirmEmail;
use Submtd\EmailConfirmation\Events\EmailConfirmed;
use Submtd\EmailConfirmation\Events\FailedEmailConfirmation;

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
            flash(['view' => 'email-confirmation::Messages.Generic', 'message' => 'Invalid user id', 'severity' => 'warning']);
            return redirect($this->redirectOnFail);
        }
        if ($user->confirmed) {
            flash(['view' => 'email-confirmation::Messages.AlreadyConfirmed']);
            return redirect($this->redirectOnAlreadyConfirmed);
        }
        if ($user->confirmation_token != $token) {
            event(new FailedEmailConfirmation($user));
            flash(['view' => 'email-confirmation::Messages.Generic', 'message' => 'Invalid confirmation token', 'severity' => 'danger']);
            return redirect($this->redirectOnFail);
        }
        $user->confirmation_token = null;
        $user->confirmed = true;
        $user->save();
        event(new EmailConfirmed($user));
        Auth::loginUsingId($user->id);
        flash(['view' => 'email-confirmation::Messages.Confirmed', 'severity' => 'success']);
        return redirect($this->redirectOnSuccess);
    }

    public function resend($id)
    {
        if (!$user = $this->model::find($id)) {
            abort(403);
        }
        if ($user->confirmed) {
            flash(['view' => 'email-confirmation::Messages.AlreadyConfirmed']);
            return redirect()->back();
        }
        if (!$user->confirmation_token) {
            $user->confirmation_token = str_random(32);
            $user->save();
        }
        // todo: send confirmation email
        Mail::to($user)->queue(new ConfirmEmail($user));
        flash(['view' => 'email-confirmation::Messages.PleaseConfirm', 'user' => $user]);
        return redirect($this->redirectOnResend);
    }
}
