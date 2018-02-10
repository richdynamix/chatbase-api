<?php

namespace Richdynamix\Chatbase\Entities;

class FieldsManager
{
    protected $data = [];

    /**
     * FieldsManager constructor.
     * @param string $apiKey
     * @param string $platform
     */
    public function __construct(string $apiKey, string $platform)
    {
        $this->data = [
            'api_key' => $apiKey,
            'platform' => $platform,
            'type' => 'user',
            'time_stamp' => $this->getTimeStamp(),
        ];
    }

    /**
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey(string $apiKey)
    {
        $this->data['api_key'] = $apiKey;

        return $this;
    }

    /**
     * @param string $platform
     * @return $this
     */
    public function setPlatform(string $platform)
    {
        $this->data['platform'] = $platform;

        return $this;
    }

    /**
     * @return $this
     */
    public function notHandled()
    {
        $this->data['not_handled'] = true;

        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type)
    {
        $this->data['type'] = $type;

        return $this;
    }

    /**
     * @param string $intent
     * @return $this
     */
    public function setIntent(string $intent)
    {
        $this->data['intent'] = $intent;

        return $this;
    }

    /**
     * @param string $customSessionId
     * @return $this
     */
    public function setCustomSessionId(string $customSessionId)
    {
        $this->data['custom_session_id'] = $customSessionId;

        return $this;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion(string $version)
    {
        $this->data['version'] = $version;

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message)
    {
        $this->data['message'] = $message;

        return $this;
    }

    /**
     * @param string $userId
     * @return $this
     */
    public function setUserId(string $userId)
    {
        $this->data['user_id'] = $userId;

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
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function mergeFieldsToSend(array $data)
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * Reset default fields between sends
     */
    public function resetFields(): void
    {
        $data = $this->data;

        unset($this->data);

        $this->data = [
            'api_key' => $data['api_key'],
            'platform' => $data['platform'],
            'type' => 'user',
            'time_stamp' => $this->getTimeStamp(),
        ];
    }
}
