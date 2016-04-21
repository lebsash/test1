<?php

namespace GAPlatform\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Manual session start so we can get the Legacy session info
         */
        if (!isset($_SESSION)) {
            @session_start();
        }
    }
}
