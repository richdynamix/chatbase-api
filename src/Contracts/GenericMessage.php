<?php

namespace Richdynamix\Chatbase\Contracts;

interface GenericMessage
{
    const SINGLE_MESSAGE_URI = '/message';
    const MULTIPLE_MESSAGE_URI = '/messages';

    public function userMessage();

    public function notHandledUserMessage();

    public function botMessage();
}
