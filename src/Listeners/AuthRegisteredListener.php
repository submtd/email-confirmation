<?php

namespace Submtd\EmailConfirmation\Listeners;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Mail;
use Submtd\EmailConfirmation\Mail\ConfirmEmail;

class AuthRegisteredListener
{
    public function handle($event)
    {
        if (!config('email-confirmation.requireEmailConfirmation', true)) {
            return;
        }
        $user = $event->user;
        $user->confirmed = false;
        $user->confirmation_token = str_random(32);
        $user->save();
        Request::session()->flash('message', 'email-confirmation::Messages.PleaseConfirm');
        Request::session()->flash('message_data', $user);
        Mail::to($user)->queue(new ConfirmEmail($user));
    }
}
