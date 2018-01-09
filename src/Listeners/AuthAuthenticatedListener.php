<?php

namespace Submtd\EmailConfirmation\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthAuthenticatedListener
{
    public function handle($event)
    {
        if (!config('email-confirmation.requireEmailConfirmation', true)) {
            return;
        }
        if (!Auth::user()->confirmed) {
            Auth::logout();
            Request::session()->flash('status', $event->user->confirmation_token);
        }
    }
}
