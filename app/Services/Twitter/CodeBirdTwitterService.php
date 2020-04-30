<?php

namespace App\Services\Twitter;

use App\Services\Twitter\Exceptions\RateLimitExceededException;
use App\Services\Twitter\TwitterService;
use Codebird\Codebird;
use Exception;

class CodeBirdTwitterService implements TwitterService
{
    protected $client;
    public function __construct(Codebird $client)
    {
        $this->client = $client;
        
    }
    public function getMentions($since = null)
    {
        try{
            $mentions = $this->client->statuses_mentionsTimeline($since ? 'since_id='. $since: '');

        if ((int) $mentions->rate->remaining === 0) {
            throw new RateLimitExceededException;
            exit(1);
        }

        return collect($this->extractTweets($mentions));
        } catch(Exception $e){
            throw new Exception('Unable to fetch mentions.');
        }
    }
    public function sendTweet($tweet, $inReplyTo = null)
    {
        $params = [
            'status' => $tweet,
        ];

        if ($inReplyTo) {
            $params['in_reply_to_status_id'] = $inReplyTo;
        }

        $this->client->statuses_update($params);
    }

    protected function extractTweets($response)
    {
        unset($response->rate);
        unset($response->httpstatus);

        return $response;
    }
}