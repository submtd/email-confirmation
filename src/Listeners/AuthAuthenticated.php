<?php

namespace Submtd\EmailConfirmation\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthAuthenticated
{
    public function handle($event)
    {
        if (!config('email-confirmation.requireEmailConfirmation', true)) {
            return;
        }
        if (!Auth::user()->confirmed) {
            Request::session()->flash('status', 'You must confirm your email address before logging into the site.');
            Auth::logout();
        }
    }
}
