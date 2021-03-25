<?php

namespace AymanElmalah\MyFatoorah;

use Illuminate\Support\ServiceProvider;

class MyFatoorahServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([ __DIR__ . '/config/myfatoorah.php' => config_path('myfatoorah.php')]);

        $this->mergeConfigFrom(__DIR__ . '/config/myfatoorah.php', 'myfatoorah');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('myfatoorah', function () {
            return new MyFatoorah();
        });
    }
}
