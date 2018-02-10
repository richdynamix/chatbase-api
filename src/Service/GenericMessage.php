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
     * @param $userId
     * @return $this
     */
    public function withUserId($userId)
    {
        $this->fieldsManager->setUserId($userId);

        return $this;
    }

    /**
     * @param $intent
     * @return $this
     */
    public function withIntent($intent)
    {
        $this->fieldsManager->setIntent($intent);

        return $this;
    }

    /**
     * @param $message
     * @return $this
     */
    public function withMessage($message)
    {
        $this->fieldsManager->setMessage($message);

        return $this;
    }

    /**
     * @param $version
     * @return $this
     */
    public function withVersion($version)
    {
        $this->fieldsManager->setVersion($version);

        return $this;
    }

    /**
     * @param $customSessionId
     * @return $this
     */
    public function withCustomSessionId($customSessionId)
    {
        $this->fieldsManager->setCustomSessionId($customSessionId);

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
     * @param array $fields
     * @return $this
     */
    public function with(array $fields)
    {
        $this->fieldsManager->mergeFieldsToSend($fields);

        return $this;
    }

    /**
     * @return mixed
     */
    public function userMessage()
    {
        $this->fieldsManager->resetFields();

        return $this;
    }

    /**
     * @return mixed
     */
    public function botMessage()
    {
        $this->fieldsManager->resetFields();

        $this->fieldsManager->setType('agent');

        return $this;
    }

    /**
     * @return mixed
     */
    public function notHandledUserMessage()
    {
        $this->fieldsManager->resetFields();

        $this->fieldsManager->notHandled();

        return $this;
    }

    /**
     * @return mixed
     */
    public function send()
    {
        return $this->sendToChatbase(self::SINGLE_MESSAGE_URI, $this->fieldsManager->getData());
    }

    /**
     * @param string $uri
     * @param array $data
     * @return mixed
     */
    private function sendToChatbase(string $uri, array $data)
    {
        $response = $this->client->post($uri, $data);

        return json_decode($response->getBody()->getContents());
    }
}
