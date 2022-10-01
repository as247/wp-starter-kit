<?php

namespace App\Http\Middleware;

use WpStarter\Http\Request;
use WpStarter\Support\Str;

class RedirectToMainDomain
{
    function handle(Request  $request, \Closure $next){
        if(!Str::contains($request->getHost(),'tinyinstaller.top')){
            $url=$request->fullUrl();
            $url=str_replace($request->getHost(),'tinyinstaller.top',$url);
            return redirect()->to($url);
        }
        return $next($request);
    }
}
