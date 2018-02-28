<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Swaggest\JsonDiff\JsonDiff;

class JsonDiffServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

     /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('Swaggest\JsonDiff\JsonDiff', function () {
            return new JsonDiff;
        });
    }
}