<?php

namespace Submtd\EmailConfirmation\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Authenticated;
use Submtd\EmailConfirmation\Listeners\AuthRegistered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Submtd\EmailConfirmation\Listeners\AuthAuthenticated;

class EmailConfirmationEvent extends EventServiceProvider
{
    protected $listen = [
        Registered::class => [
            AuthRegistered::class,
        ],
        Authenticated::class => [
            AuthAuthenticated::class,
        ],
    ];
}
