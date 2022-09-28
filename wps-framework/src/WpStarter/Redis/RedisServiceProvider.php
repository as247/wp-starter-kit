<?php

namespace WpStarter\Redis;

use WpStarter\Contracts\Support\DeferrableProvider;
use WpStarter\Support\Arr;
use WpStarter\Support\ServiceProvider;

class RedisServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('redis', function ($app) {
            $config = $app->make('config')->get('database.redis', []);

            return new RedisManager($app, Arr::pull($config, 'client', 'phpredis'), $config);
        });

        $this->app->bind('redis.connection', function ($app) {
            return $app['redis']->connection();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['redis', 'redis.connection'];
    }
}