<?php

namespace Vittozich\Modulara\Providers;

use Illuminate\Support\ServiceProvider;
use Vittozich\Modulara\Modular;

class ModularaAppServiceProvider extends ServiceProvider
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
        $modular = app(Modular::class);
        $this->loadMigrationsFrom(array_merge(
            [
                database_path() . DIRECTORY_SEPARATOR . 'migrations'
            ],
            $modular->getOnlyMigrationsPath()
        ));

        $views = $modular->getOnlyViewsPath();

        if (count($views) != 0)
            foreach ($views as $moduleName => $moduleViewsDirectory)
                $this->loadViewsFrom($moduleViewsDirectory, $moduleName);

    }
}
