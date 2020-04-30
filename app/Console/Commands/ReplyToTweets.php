<?php

namespace App\Console\Commands;

use App\Common\EmojiHelper;
use App\Jobs\SendTweet;
use App\Services\Twitter\Exceptions\RateLimitExceededException;
use App\Services\Twitter\TwitterService;
use App\Tracking;
use Exception;
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
    protected $ml;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TwitterService $twitter, EmojiHelper $emojis)
    {
        parent::__construct();
        $this->twitter = $twitter;
        $this->ml = app()->make('monkeylearn');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Tracking $tracking)
    {
        $tracked = $tracking->latestFirst();

        try {
            $mentions = $this->twitter->getMentions($tracked->count() ? $tracked->first()->twitter_id : null);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }

        if (!$mentions->count()) {
            return $this->info('No mentions to process at the moment');
        }

        $text = $mentions->map(function ($mention) {
            return $mention->text;
        });

        $sentiments = $this->ml->classifiers->classify('cl_pi3C7JiL', $text->toArray(), true);

        $mentions->each(function ($mention, $index) use ($sentiments, $emojis) {
            dispatch(new SendTweet(
                $mention->id,
                $mention->user->screen_name,
                $emojis->random($sentiments->result[$index][0]['label'])
            ));
        });
    }
}
