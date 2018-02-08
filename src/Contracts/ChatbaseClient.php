<?php

namespace Richdynamix\Chatbase\Contracts;

interface ChatbaseClient
{
    const BASE_URL = 'https://chatbase.com/api';

    public function post(string $uri, array $body);
}