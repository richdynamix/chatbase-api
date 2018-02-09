<?php

namespace Richdynamix\Chatbase\Service;

use Richdynamix\Chatbase\Entities\FieldsManager;
use Richdynamix\Chatbase\Contracts\ChatbaseClient;
use Richdynamix\Chatbase\Contracts\GenericMessage as Contract;

class GenericMessage implements Contract
{
    private $client;

    private $fieldsManager;

    /**
     * GenericMessage constructor.
     * @param ChatbaseClient $client
     * @param FieldsManager $fieldsManager
     */
    public function __construct(ChatbaseClient $client, FieldsManager $fieldsManager)
    {
        $this->client = $client;
        $this->fieldsManager = $fieldsManager;
    }

    /**
     * @param string $platform
     * @return $this
     */
    public function setPlatform(string $platform)
    {
        $this->fieldsManager->setPlatform($platform);

        return $this;
    }

    /**
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey(string $apiKey)
    {
        $this->fieldsManager->setApiKey($apiKey);

        return $this;
    }

    /**
     * @param array ...$params
     * @return mixed
     */
    public function userMessage(...$params)
    {
        $data = $this->fieldsManager->getFieldsToSend($params);

        return $this->send(self::SINGLE_MESSAGE_URI, $data);
    }

    /**
     * @param array ...$params
     * @return mixed
     */
    public function botMessage(...$params)
    {
        $data = $this->fieldsManager->setType('agent')->getFieldsToSend($params);

        return $this->send(self::SINGLE_MESSAGE_URI, $data);
    }

    /**
     * @param array ...$params
     * @return mixed
     */
    public function notHandledUserMessage(...$params)
    {
        $data = $this->fieldsManager->notHandled()->getFieldsToSend($params);

        return $this->send(self::SINGLE_MESSAGE_URI, $data);
    }

    /**
     * @param string $uri
     * @param array $data
     * @return mixed
     */
    private function send(string $uri, array $data)
    {
        $response = $this->client->post($uri, $data);

        return json_decode($response->getBody()->getContents());
    }
}
