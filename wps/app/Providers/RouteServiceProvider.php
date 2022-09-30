<?php

namespace App\Providers;

use WpStarter\Cache\RateLimiting\Limit;
use WpStarter\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use WpStarter\Http\Request;
use WpStarter\Support\Facades\Auth;
use WpStarter\Support\Facades\RateLimiter;
use WpStarter\Support\Facades\Route;
use WpStarter\Wordpress\Response;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::get('/abc',function(){
                dd(ws_auth()->user());
            });
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
            return Limit::perMinute(60)->by(ws_optional($request->user())->id ?: $request->ip());
        });
    }
}
