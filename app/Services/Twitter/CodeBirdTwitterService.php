<?php

namespace App\Services\Twitter;
use App\Services\Twitter\TwitterService;
use Codebird\Codebird;

class CodeBirdTwitterService implements TwitterService
{
    protected $client;
    public function __construct(Codebird $client)
    {
        $this->client = $client;
        
    }
    public function getMentions($since = null)
    {
        return 'get metntions';
    }
    public function sendTweet($tweet, $inReplyTo = null)
    {
        return 'send tweet';
    }
}