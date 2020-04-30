<?php

namespace App\Services\Twitter\Exceptions;

use Exception;

class RateLimitExceededException extends Exception
{
    public $message = "Rate limit exceeded.";
}