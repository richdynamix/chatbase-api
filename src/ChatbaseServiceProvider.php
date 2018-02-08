<?php

namespace Richdynamix\Chatbase;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Richdynamix\Chatbase\Service\ChatbaseClient;
use Richdynamix\Chatbase\Service\GenericMessage;
use Richdynamix\Chatbase\Exceptions\InvalidConfiguration;
use Richdynamix\Chatbase\Contracts\GenericMessage as GenericMessageContract;
use Richdynamix\Chatbase\Contracts\ChatbaseClient as ChatbaseClientContract;

class ChatbaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/chatbase.php' => config_path('chatbase.php'),
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/chatbase.php', 'chatbase');

        $this->app->bind(ChatbaseClientContract::class, function () {
            $guzzle = app(Client::class);

            return new ChatbaseClient($guzzle);
        });

        $this->app->bind(GenericMessageContract::class, function () {
            $config = config('chatbase');

            $this->guardAgainstInvalidConfiguration($config);

            $client = app(ChatbaseClientContract::class);

            return new GenericMessage($client, $config['api_key']);
        });
    }

    /**
     * @param array|null $config
     * @throws InvalidConfiguration
     */
    protected function guardAgainstInvalidConfiguration(array $config = null)
    {
        if (empty($config['api_key'])) {
            throw InvalidConfiguration::apiKeyNotSpecified();
        }
    }
}
