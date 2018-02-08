<?php

namespace Richdynamix\Chatbase\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function apiKeyNotSpecified()
    {
        return new static('You must provide a valid API Key to send data to Chatbase');
    }
}
