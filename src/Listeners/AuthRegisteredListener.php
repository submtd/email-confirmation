<?php

namespace Submtd\EmailConfirmation\Listeners;

use Illuminate\Support\Facades\Mail;
use Submtd\EmailConfirmation\Mail\ConfirmEmail;

/**
 * The AuthRegisteredListener class listens for
 * Illuminate\Auth\Events\Registered events. When an event happens,
 * a confirmation email is sent to the user.
 */
class AuthRegisteredListener
{
    /**
     * Handles Illuminate\Auth\Events\Registered events.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        // check to see if email confirmation is required
        if (!config('email-confirmation.requireEmailConfirmation', true)) {
            // email confirmation is not required so carry on
            return;
        }
        // grab create a confirmation token for the user
        $user = $event->user;
        $user->confirmed = false;
        $user->confirmation_token = str_random(32);
        $user->save();
        // send a confirmation email to the user
        Mail::to($user)->queue(new ConfirmEmail($user));
    }
}
