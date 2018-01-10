<?php

namespace Submtd\EmailConfirmation\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Mail;
use Submtd\EmailConfirmation\Mail\ConfirmEmail;

class ConfirmationController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = config('auth.providers.users.model');
    }

    public function confirm($id, $token)
    {
        if (!$user = $this->model::find($id)) {
            abort(404);
        }
        if ($user->confirmed) {
            return redirect()->route('login')->with('status', config('email-confirmation.statusMessages.alreadyConfirmed'));
        }
        if ($user->confirmation_token != $token) {
            abort(403);
        }
        $user->confirmation_token = null;
        $user->confirmed = true;
        $user->save();
        Request::session()->flash('status', config('email-confirmation.statusMessages.confirmed'));
        return redirect(route('login'));
    }

    public function resend($id)
    {
        if (!$user = $this->model::find($id)) {
            abort(403);
        }
        if ($user->confirmed) {
            Request::session()->flash('status', config('email-confirmation.statusMessages.alreadyConfirmed'));
            return redirect()->back();
        }
        $user->confirmation_token = str_random(32);
        $user->save();
        // todo: send confirmation email
        Mail::to($user)->queue(new ConfirmEmail($user));
        return redirect(route('login'));
    }
}
