<?php

namespace App\Providers;

use App\Component\HelloComponent;
use WpStarter\Cache\RateLimiting\Limit;
use WpStarter\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use WpStarter\Http\Request;
use WpStarter\Support\Facades\RateLimiter;
use WpStarter\Support\Facades\Route;
use WpStarter\Wordpress\Response\Content;
use WpStarter\Wordpress\Response\Shortcode;

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
                    return shortcode_view('main','a',['text'=>'this a shortcode']);
                }else{
                    return content_view(function ($data){
                        dd($data);
                        return 'hello';
                    },['abc'],['def']);
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
