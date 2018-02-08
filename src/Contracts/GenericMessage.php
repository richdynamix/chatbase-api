<?php

namespace Richdynamix\Chatbase\Contracts;

interface GenericMessage
{
    const SINGLE_MESSAGE_URI = '/message';
    const MULTIPLE_MESSAGE_URI = '/messages';

    /**
     * @param array $data
     * @return array
     */
    public function recordMessage(array $data);

    /**
     * @param array $data
     * @return array
     */
    public function recordFailedMessage(array $data);

    /**
     * @param array $data
     * @return array
     */
    public function recordBotMessage(array $data);

    /**
     * @param array $messages
     * @return array
     */
    public function recordMultiple(array $messages);
}
