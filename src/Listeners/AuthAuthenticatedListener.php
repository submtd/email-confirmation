<?php

namespace Submtd\EmailConfirmation\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * The AuthAuthenticatedListener class listens for
 * Illuminate\Auth\Events\Authenticated events. When an event happens,
 * if the user is not confirmed, this listener will log them out.
 */
class AuthAuthenticatedListener
{
    /**
     * Handles Illuminate\Auth\Events\Authenticated events.
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
        // check to see if the user's email address has been confirmed
        if (!Auth::user()->confirmed) {
            // the email address has not been confirmed, so flash a message and logout
            Request::session()->flash('status', 'You must confirm your email address before logging in.');
            Auth::logout();
        }
    }
}
