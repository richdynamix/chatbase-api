<?php

namespace Richdynamix\Chatbase\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use Richdynamix\Chatbase\Exceptions\WrongDataSet;
use Richdynamix\Chatbase\Contracts\ChatbaseClient as Contract;

class ChatbaseClient implements Contract
{
    /**
     * @var Client
     */
    private $client;

    /**
     * ChatbaseClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $uri
     * @param array $body
     * @return Response
     * @throws WrongDataSet
     */
    public function post(string $uri, array $body): Response
    {
        try {
            $response = $this->client->request('POST', $this->getFullApiEndpoint($uri), [
                'json'  => $body
            ]);
        } catch (ClientException $e) {
            throw WrongDataSet::invalidValuesProvided();
        }

        return $response;
    }

    /**
     * @param string $uri
     * @return string
     */
    private function getFullApiEndpoint(string $uri): string
    {
        return self::BASE_URL . $uri;
    }
}
