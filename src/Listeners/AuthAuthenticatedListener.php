<?php

namespace Submtd\EmailConfirmation\Listeners;

use Illuminate\Support\Facades\Auth;

class AuthAuthenticatedListener
{
    public function handle($event)
    {
        if (!config('email-confirmation.requireEmailConfirmation', true)) {
            return;
        }
        if (!Auth::user()->confirmed) {
            flash(parseMessage('email-confirmation.statusMessages.confirm', ['user' => Auth::user()]));
            Auth::logout();
        }
    }
}
