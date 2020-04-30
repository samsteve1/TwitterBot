<?php

namespace App\Services\Twitter;

interface TwitterService
{
    public function getMentions($since = null);
    public function sendTweet($tweet, $inReplyTo = null);
}