<?php

namespace Richdynamix\Chatbase\Exceptions;

use Exception;

class WrongDataSet extends Exception
{
    /**
     * @return static
     */
    public static function invalidValuesProvided()
    {
        return new static('Some of the provided fields have invalid values');
    }

    /**
     * @return static
     */
    public static function requiresMultipleMessages()
    {
        return new static('Multiple messages should be passed to [sendMultiple] method');
    }
}