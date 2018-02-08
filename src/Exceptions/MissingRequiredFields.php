<?php

namespace Richdynamix\Chatbase\Exceptions;

use Exception;

class MissingRequiredFields extends Exception
{
    /**
     * @return static
     */
    public static function userIdRequired()
    {
        return new static('The user_id field is required');
    }

    /**
     * @return static
     */
    public static function platformRequired()
    {
        return new static('The platform field is required');
    }
}