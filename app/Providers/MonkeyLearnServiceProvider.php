<?php

namespace App\Providers;

use MonkeyLearn\Client as MonkeyLearn;
use Illuminate\Support\ServiceProvider;

class MonkeyLearnServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('monkeylearn', function ($app) {
            return new MonkeyLearn(env('MONKEY_LEARN_SECRET'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
