<?php

namespace App\Http\Middleware;


class ScopeModelMiddleware
{
    function handle($request,$next){
        return $next($request);
    }
}
