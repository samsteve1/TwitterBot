<?php

namespace App\Providers;

use App\Services\Twitter\CodeBirdTwitterService;
use App\Services\Twitter\TwitterService;
use Codebird\Codebird;
use Illuminate\Support\ServiceProvider;

class TwitterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TwitterService::class, function($app) {
            $cb = Codebird::getInstance();
            $cb->setToken(env('TWITTER_ACCESS_TOKEN'), env('TWITTER_ACCESS_SECRET_TOKEN'));
            return new CodeBirdTwitterService($cb);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Codebird::setConsumerKey(env('TWITTER_CONSUMER_KEY'), env('TWITTER_API_SECRET'));
    }
}
