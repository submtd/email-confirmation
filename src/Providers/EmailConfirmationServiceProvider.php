<?php

namespace Submtd\EmailConfirmation\Providers;

use Illuminate\Support\ServiceProvider;

class EmailConfirmationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // routes
        require __DIR__ . '/../Routes.php';
        // views
        $this->loadViewsFrom(__DIR__ . '/../Views', 'email-confirmation');
        $this->publishes([__DIR__ . '/../Views' => resource_path('views/vendor/email-confirmation')], 'views');
        // migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->publishes([__DIR__ . '/../Database/Migrations' => database_path('migrations')], 'migrations');
        // config
        $this->mergeConfigFrom(__DIR__ . '/../Config/email-confirmation.php', 'email-confirmation');
        $this->publishes([__DIR__ . '/../Config' => config_path()], 'config');
    }
}
