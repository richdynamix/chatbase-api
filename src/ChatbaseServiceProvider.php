<?php

namespace Richdynamix\Chatbase;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Richdynamix\Chatbase\Entities\FieldsManager;
use Richdynamix\Chatbase\Service\ChatbaseClient;
use Richdynamix\Chatbase\Service\GenericMessage;
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
            $client = app(ChatbaseClientContract::class);

            $fieldsManager = app(FieldsManager::class);

            return new GenericMessage($client, $fieldsManager);
        });
    }
}
