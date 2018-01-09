<?php

namespace Submtd\EmailConfirmation;

use Illuminate\Support\ServiceProvider;

class EmailConfirmationServiceProvider extends ServiceProvider
{
    protected $commands = [];

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    public function boot()
    {
        require __DIR__ . '/Routes.php';
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/Config/email-confirmation.php', 'email-confirmation');
    }
}
