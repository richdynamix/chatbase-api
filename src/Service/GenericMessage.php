<?php

namespace Richdynamix\Chatbase\Service;

use Richdynamix\Chatbase\Exceptions\WrongDataSet;
use Richdynamix\Chatbase\Contracts\ChatbaseClient;
use Richdynamix\Chatbase\Contracts\GenericMessage as Contract;

class GenericMessage implements Contract
{
    /**
     * @var ChatbaseClient
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * GenericMessage constructor.
     * @param ChatbaseClient $client
     * @param string $apiKey
     */
    public function __construct(ChatbaseClient $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @param array $data
     * @return array
     */
    public function sendFailedMessage(array $data)
    {
        return $this->send(self::SINGLE_MESSAGE_URI, array_merge($data, [
            'api_key' => $this->apiKey,
            'not_handled' => true,
            'type' => 'user',
            'time_stamp' => $this->getMilliseconds()
        ]));
    }

    /**
     * @param array $data
     * @return array
     */
    public function sendBotMessage(array $data)
    {
        return $this->send(self::SINGLE_MESSAGE_URI, array_merge($data, [
            'api_key' => $this->apiKey,
            'type' => 'agent',
            'time_stamp' => $this->getMilliseconds()
        ]));
    }

    /**
     * @param array $data
     * @return array
     */
    public function sendOne(array $data)
    {
        return $this->send(self::SINGLE_MESSAGE_URI, array_merge($data, [
            'api_key' => $this->apiKey,
            'type' => 'user',
            'time_stamp' => $this->getMilliseconds()
        ]));
    }

    /**
     * @param array $messages
     * @return mixed
     * @throws WrongDataSet
     */
    public function sendMultiple(array $messages)
    {
        if (isset($messages[0]) && is_array($messages[0])) {
            $data = $this->prepareMultipleMessages($messages);

            return $this->send(self::MULTIPLE_MESSAGE_URI, $data);
        }

        throw WrongDataSet::requiresMultipleMessages();
    }

    /**
     * @param string $uri
     * @param array $data
     * @return array
     */
    private function send(string $uri, array $data)
    {
        $response = $this->client->post($uri, $data);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @return string
     */
    private function getMilliseconds(): string
    {
        $microtime = round(microtime(true) * 1000);

        return number_format($microtime, 0, ".", "");
    }

    /**
     * @param array $messages
     * @return array
     */
    private function prepareMultipleMessages(array $messages): array
    {
        $data = [];
        foreach ($messages as $message) {
            $data[] = array_merge($message, [
                'api_key' => $this->apiKey,
                'type' => 'user',
                'time_stamp' => $this->getMilliseconds()
            ]);
        }

        return $data;
    }
}
