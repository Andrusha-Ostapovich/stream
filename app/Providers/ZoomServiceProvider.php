<?php

namespace App\Providers;

use App\Support\Zoom\Facades\Zoom;
use Illuminate\Support\ServiceProvider;

class ZoomServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // if ($this->app->runningInConsole()) {
        //     $this->publishes([
        //         __DIR__ . '/../config/config.php' => config_path('zoom.php'),
        //     ], 'config');
        // }

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->app->bind('zoom', function ($app) {
            return new Zoom();
        });

    }
}
