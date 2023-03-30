<?php

namespace Vittozich\Modulara;

use Illuminate\Support\ServiceProvider;
use Vittozich\Modulara\Console\PublishBaseModularCommand;
use Vittozich\Modulara\Console\PublishConfigCommand;
use Vittozich\Modulara\Providers\ModularaAppServiceProvider;

class ModularaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishBaseModularCommand::class,
                PublishConfigCommand::class
            ]);
        }
        $this->loadRoutesFrom(__DIR__ . '/Modular/Base/Routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/Modular/Base/Routes/web.php');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/modulara.php', 'modulara'
        );

        $this->app->register(ModularaAppServiceProvider::class);
    }
}