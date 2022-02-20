<?php

namespace Vittozich\Modulara;

use Illuminate\Support\ServiceProvider;
use Vittozich\Modulara\Console\PublishBaseModularCommand;
use Vittozich\Modulara\Console\PublishConfigCommand;

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
    }

    public function register()
    {

    }
}