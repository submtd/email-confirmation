<?php

namespace Submtd\EmailConfirmation\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * The EmailConfirmationListeners class defines event listeners
 * for when a user authenticates or registers.
 */
class EmailConfirmationListeners extends EventServiceProvider
{
    /**
     * The listen array defines the events that we should listen
     * for and the classes to handle those events.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Registered' => [
            'Submtd\EmailConfirmation\Listeners\AuthRegisteredListener',
        ],
        'Illuminate\Auth\Events\Authenticated' => [
            'Submtd\EmailConfirmation\Listeners\AuthAuthenticatedListener',
        ],
    ];
}
