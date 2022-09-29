<?php

namespace App\Providers;

use App\Events\InstallationFinished;
use App\Events\InstallationRead;
use App\Events\InstallationStarted;
use App\Listeners\InstallationDoneListener;
use App\Listeners\InstallationReadListener;
use App\Listeners\InstallationStartedListener;
use App\Listeners\UsageStatistic;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        InstallationStarted::class=>[
            InstallationStartedListener::class,
        ],
        InstallationRead::class=>[
            InstallationReadListener::class,
        ],
        InstallationFinished::class=>[
            InstallationDoneListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
