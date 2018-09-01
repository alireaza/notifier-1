<?php

namespace Asanbar\Notifier;

use Illuminate\Support\ServiceProvider;

class NotifierServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        include_once __DIR__ . "/routes/web.php";
        include_once __DIR__ . "/Notifier.php";
        
        $this->mergeConfigFrom(__DIR__.'/Config/notifier.php' , 'notifier');
        
    }
}
