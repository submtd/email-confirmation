<?php

namespace Submtd\EmailConfirmation\Listeners;

class AuthRegistered
{
    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        $user = $event->user;
        $user->confirmed = false;
        $user->confirmation_token = str_random(100);
        $user->save();
        dd($user);
    }
}
