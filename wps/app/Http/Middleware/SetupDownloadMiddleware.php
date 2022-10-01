<?php

namespace App\Http\Middleware;

use WpStarter\Http\Request;
use WpStarter\Support\Fluent;
use WpStarter\Support\Str;
class SetupDownloadMiddleware
{
    function handle(Request $request,\Closure $next){

        if(Str::contains($request->userAgent(),'Wget')){
            return response()->view('ti.setup');
        }
        return $next($request);
    }
}
