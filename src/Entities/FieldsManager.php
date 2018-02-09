<?php

namespace Richdynamix\Chatbase\Entities;

class FieldsManager
{
    protected $fields = [
        'user_id',
        'message',
        'intent',
        'version',
        'custom_session_id'
    ];

    protected $data = [];
    protected $apiKey = '';
    protected $message = '';
    protected $platform = '';
    protected $intent = '';
    protected $version = '';
    protected $customSessionId = '';
    protected $notHandled = false;
    protected $type = 'user';
    protected $timeStamp = '';

    /**
     * FieldsManager constructor.
     * @param string $apiKey
     * @param string $platform
     */
    public function __construct(string $apiKey, string $platform)
    {
        $this->apiKey = $apiKey;
        $this->platform = $platform;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @param string $platform
     */
    public function setPlatform(string $platform)
    {
        $this->platform = $platform;
    }

    /**
     * @return string
     */
    public function getNotHandled(): string
    {
        return $this->notHandled;
    }

    /**
     * @return $this
     */
    public function notHandled()
    {
        $this->notHandled = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    private function getTimeStamp(): string
    {
        $microtime = round(microtime(true) * 1000);

        return number_format($microtime, 0, ".", "");
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $this->data = [
            'api_key' => $this->getApiKey(),
            'platform' => $this->getPlatform(),
            'type' => $this->getType(),
            'time_stamp' => $this->getTimeStamp(),
        ];

        if ($this->notHandled) {
            $this->data['not_handled'] = true;
        }

        return $this->data;
    }

    /**
     * @param array ...$params
     * @return array
     */
    public function getFieldsToSend(...$params)
    {
        array_splice($this->fields, (count($params)));

        return array_merge(array_combine($this->fields, $params), $this->getData());
    }
}
