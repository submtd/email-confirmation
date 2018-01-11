<?php

namespace Submtd\EmailConfirmation\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Authenticated;
use Submtd\EmailConfirmation\Listeners\AuthRegisteredListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Submtd\EmailConfirmation\Listeners\AuthAuthenticatedListener;

class EmailConfirmationListeners extends EventServiceProvider
{
    protected $listen = [
        Registered::class => [
            AuthRegisteredListener::class,
        ],
        Authenticated::class => [
            AuthAuthenticatedListener::class,
        ],
    ];
}
