<?php

namespace Richdynamix\Chatbase\Contracts;

interface GenericMessage
{
    const SINGLE_MESSAGE_URI = '/message';
    const MULTIPLE_MESSAGE_URI = '/messages';

    /**
     * @param array ...$fields
     * @return mixed
     */
    public function userMessage(...$fields);

    /**
     * @param array ...$fields
     * @return mixed
     */
    public function notHandledUserMessage(...$fields);

    /**
     * @param array ...$fields
     * @return mixed
     */
    public function botMessage(...$fields);
}
