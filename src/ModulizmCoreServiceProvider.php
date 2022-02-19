<?php

namespace Modulizm\Core;

use Illuminate\Support\ServiceProvider;

class ModulizmCoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/modulizm.php' => config_path('modulizm.php')
        ]);
    }

    public function register()
    {

    }
}