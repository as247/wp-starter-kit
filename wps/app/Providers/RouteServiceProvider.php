<?php

namespace App\Providers;

use WpStarter\Cache\RateLimiting\Limit;
use WpStarter\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use WpStarter\Http\Request;
use WpStarter\Support\Facades\RateLimiter;
use WpStarter\Support\Facades\Route;
use WpStarter\Wordpress\Response\Content;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::get('/abc',function(\WP_User $user){
                return Content::make('a');
            })->middleware('api');

            Route::get('/sample-page',function(){
                if(ws_request('full')) {
                    return ws_view('a', ['text' => 'This is ws view']);
                }else{
                    return wp_view('a',['text'=>'This is wp view'])->withTitle('Custom title');
                }
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
            return Limit::perMinute(5)->by(ws_optional($request->user())->id ?: $request->ip());
        });
    }
}
