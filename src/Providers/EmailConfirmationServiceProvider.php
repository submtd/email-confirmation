<?php

namespace Submtd\EmailConfirmation\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * The EmailConfirmationServiceProvider class is the main
 * entry point for the package.
 */
class EmailConfirmationServiceProvider extends ServiceProvider
{
    /**
     * The service provider boot method
     *
     * @return void
     */
    public function boot()
    {
        // require our routes file
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
