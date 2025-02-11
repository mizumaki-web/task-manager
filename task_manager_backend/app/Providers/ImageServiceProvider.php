<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;

class ImageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('ImageManager', function ($app) {
            return new ImageManager();
        });
    }

    public function boot()
    {
        //
    }
}
