<?php

namespace Vittozich\Modulara;

use Illuminate\Support\ServiceProvider;
use Vittozich\Modulara\Console\PublishBaseModularCommand;

class ModularaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/modulara.php' => config_path('modulara.php')
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishBaseModularCommand::class,
            ]);
        }
    }

    public function register()
    {

    }
}