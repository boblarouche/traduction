<?php

namespace Boblarouche\Traduction;

use Boblarouche\Traduction\Commands\TraductionMissing;
use Illuminate\Support\ServiceProvider;

class TraductionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        
        if ($this->app->runningInConsole()) {
            // Registering package commands.
            $this->commands([
                TraductionMissing::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('traduction', function () {
            return new Traduction;
        });
    }
}
