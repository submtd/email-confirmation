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
        dd($event);
    }
}
