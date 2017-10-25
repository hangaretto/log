<?php

namespace Magnetar\Log;

use Illuminate\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider
{
    //protected $commands = [
    //    'Magnetar\Tariffs\Commands\TariffExpired',
    //];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if(config('magnetar.log.controllers.enabled') == true)
            include __DIR__.'/routes.php';

        $this->publishes([
            __DIR__.'/config/log.php' => config_path('magnetar/log.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/migrations' => database_path('migrations')
        ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Magnetar\Log\Controllers\LogController');
        //$this->commands($this->commands);
    }
}
