<?php

namespace Submtd\EmailConfirmation\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ConfirmationController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = config('auth.providers.users.model');
    }

    public function confirm($id, $token)
    {
        if (!$user = $this->model::whereId($id)->where('confirmation_token', $token)->first()) {
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
        return redirect(route('login'));
    }
}
