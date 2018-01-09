<?php

namespace Submtd\EmailConfirmation\Listeners;

class AuthAuthenticated
{
    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        dd($event);
    }
}
