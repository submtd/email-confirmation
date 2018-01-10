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
            Request::session()->flash('message', 'email-confirmation::Messages.PleaseConfirm');
            Request::session()->flash('message_data', ['user' => Auth::user()]);
            Auth::logout();
        }
    }
}
