<?php

namespace App\Http;

use App\Http\Middleware\LogRequestMiddleware;
use App\Http\Middleware\RedirectToMainDomain;
use App\Http\Middleware\ScopeModelMiddleware;
use App\Http\Middleware\SetupDownloadMiddleware;

class Kernel extends \WpStarter\Foundation\Http\Kernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        //\Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \WpStarter\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \WpStarter\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \WpStarter\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \WpStarter\Session\Middleware\StartSession::class,
            //\WpStarter\Session\Middleware\AuthenticateSession::class,
            \WpStarter\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \WpStarter\Routing\Middleware\SubstituteBindings::class,
            ScopeModelMiddleware::class,
            SetupDownloadMiddleware::class,
            RedirectToMainDomain::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \WpStarter\Routing\Middleware\SubstituteBindings::class,
            ScopeModelMiddleware::class,
            LogRequestMiddleware::class,
        ],
    ];
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'cache.headers' => \WpStarter\Http\Middleware\SetCacheHeaders::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \WpStarter\Routing\Middleware\ValidateSignature::class,
        'throttle' => \WpStarter\Routing\Middleware\ThrottleRequests::class,
    ];
}