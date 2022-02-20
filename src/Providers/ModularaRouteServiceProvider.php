<?php

namespace Vittozich\Modulara\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Vittozich\Modulara\Modular;

class ModularaRouteServiceProvider extends ServiceProvider
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
        $this->configureRateLimiting();
        $modular = app(Modular::class);

        $this->routes(function () use ($modular) {
            foreach ($modular->getOnlyRoutesPath() as $moduleRoutePath) :
                if (file_exists($moduleRoutePath . '/api.php'))
                    Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group($moduleRoutePath . '/api.php');

                if (file_exists($moduleRoutePath . '/web.php'))
                    Route::middleware('web')
                        ->namespace($this->namespace)
                        ->group($moduleRoutePath . '/web.php');
            endforeach;
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
