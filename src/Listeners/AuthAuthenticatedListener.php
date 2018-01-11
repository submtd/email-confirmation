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
            Request::session()->flash('status', config('email-confirmation.statusMessages.confirm', 'You must confirm your email address before logging in.'));
            Auth::logout();
        }
    }
}
