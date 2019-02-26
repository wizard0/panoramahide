<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class for application service provider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        \DB::listen(function ($query) {
            info($query->sql);
            info($query->bindings);
            info($query->time);
        });
        */
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
