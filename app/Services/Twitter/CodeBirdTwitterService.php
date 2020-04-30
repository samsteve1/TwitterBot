<?php

namespace App\Services\Twitter;
use App\Services\Twitter\TwitterService;

class CodeBirdTwitterService implements TwitterService
{
    public function getMentions($since = null)
    {
        return 'get metntions';
    }
    public function sendTweet($tweet, $inReplyTo = null)
    {
        return 'send tweet';
    }
}