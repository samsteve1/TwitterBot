<?php

namespace App\Console\Commands;

use App\Services\Twitter\Exceptions\RateLimitExceededException;
use App\Services\Twitter\TwitterService;
use App\Tracking;
use Illuminate\Console\Command;

class ReplyToTweets extends Command
{
    protected $twitter;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter_bot:reply';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reply to recent mentions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TwitterService $twitter)
    {
        parent::__construct();
        $this->twitter = $twitter;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Tracking $tracking)
    {
        $tracked = $tracking->latestFirst();

        try{
            $mentions = $this->twitter->getMentions($tracked->count() ? $tracked->first()->twitter_id : null);
            
        } catch(RateLimitExceededException $e) {
            return $this->error($e->getMessage());
        }

        if (!$mentions->count()) {
            return $this->info('No mentions to process at the moment');
        }
        
    }
}
