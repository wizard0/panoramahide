<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (file_exists(base_path('config/helpers.php'))) {
            require_once(base_path('config/helpers.php'));
        }
    }
}
