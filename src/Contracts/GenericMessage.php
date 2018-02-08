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
    public function sendOne(array $data);

    /**
     * @param array $data
     * @return array
     */
    public function sendFailedMessage(array $data);

    /**
     * @param array $data
     * @return array
     */
    public function sendBotMessage(array $data);

    /**
     * @param array $messages
     * @return array
     */
    public function sendMultiple(array $messages);
}
