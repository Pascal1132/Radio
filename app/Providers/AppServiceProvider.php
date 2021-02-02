<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (file_exists(config_path('config.json'))){
            $settings = json_decode(file_get_contents(config_path('config.json')), true);

            config(['app.settings' => $settings]);
        }
    }
}
