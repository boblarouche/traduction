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
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'traduction');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'traduction');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('traduction.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/traduction'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/traduction'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/traduction'),
            ], 'lang');*/

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
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'traduction');

        // Register the main class to use with the facade
        $this->app->singleton('traduction', function () {
            return new Traduction;
        });
    }
}
