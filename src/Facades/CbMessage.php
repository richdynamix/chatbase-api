<?php

namespace Richdynamix\Chatbase\Facades;

use Illuminate\Support\Facades\Facade;
use Richdynamix\Chatbase\Contracts\GenericMessage;

/**
 * @see \Richdynamix\Chatbase\Service\GenericMessage
 */
class CbMessage extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return GenericMessage::class;
    }
}
