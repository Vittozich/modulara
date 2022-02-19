<?php

namespace Modulizm\Core;

use Illuminate\Support\ServiceProvider;

class ModulizmCoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/modulizmcore.php' => config_path('modulizmcore.php')
        ]);
    }

    public function register()
    {

    }
}