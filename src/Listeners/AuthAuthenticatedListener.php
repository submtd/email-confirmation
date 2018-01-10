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
            flash(['view' => 'email-confirmation::Messages.PleaseConfirm', 'user' => Auth::user()]);
            Auth::logout();
        }
    }
}
