#  Chatbase API for Laravel

This is the unofficial Chatbase API for Laravel. Chatbase is a Chatbot analytics service by Google.

**IN DEVELOPMENT MODE. EXPERIMENTAL CHANGES. DO NOT USE IN PRODUCTION**

## Installation

This package can be installed through Composer.

``` bash
composer require richdynamix/chatbase-api
```

In Laravel >5.5 the package will autoregister the service provider. In Laravel 5.4 you must install this service provider.

```php
// config/app.php
'providers' => [
    ...
    Richdynamix\Chatbase\ChatbaseServiceProvider::class,
    ...
];
```

In Laravel >5.5 the package will auto register the facades. In Laravel 5.4 you must install the facade manually.

```php
// config/app.php
'aliases' => [
    ...
    'Chatbase' => Richdynamix\Chatbase\Facades\Chatbase::class,
    ...
];
```

You can publish the config file of this package with this command:

``` bash
php artisan vendor:publish --provider="Richdynamix\Chatbase\ChatbaseServiceProvider"
```

The following config file will be published in `config/chatbase.php`

```php
return [
    /*
     * The Chatbase API key
     */
    'api_key' => env('CHATBASE_API_KEY'),
    'platform' => env('CHATBASE_DEFAULT_PLATFORM', 'messenger'),
];
```

**Only the Generic Messaging API is setup at present**

## IoC container

The IoC container will automatically resolve the `GenericMessage` dependencies for you. You can grab an instance of `GenericMessage` from the IoC container in a number of ways.

```php
// Directly from the IoC
$chatbase = app(Richdynamix\Chatbase\Contracts\GenericMessage::class);

// From a constructor
class FooClass {
    public function __construct(Richdynamix\Chatbase\Contracts\GenericMessage $chatbase) {
       // . . .
    }
}

// From a method
class BarClass {
    public function barMethod(Richdynamix\Chatbase\Contracts\GenericMessage $chatbase) {
       // . . .
    }
}
```

Alternatively you may use the `Chatbase` facade directly

```php
    Chatbase::userMessage($userId, $message, $intent, $version, $customSessionId)
```

```php
    Chatbase::notHandledUserMessage($userId, $message, $intent, $version, $customSessionId)
```

```php
    Chatbase::botMessage($userId, $message, $intent, $version, $customSessionId)
```

In the above examples, `$data` is an array to be sent to Chatbase.

#### Parameters to be set in each method

| field               | type   | required | description |
| ------------------- | ------ | -------- | ----------- |
| $userId             | string | Y        | the ID of the end-user |
| $message           | string | Y        | the raw message body regardless of type for example a typed-in or a tapped button or tapped image |
| intent            | string | Y        | set for user messages only; if not set usage metrics will not be shown per intent; do not set if it is a generic catch all intent, like default fallback, so that clusters of similar messages can be reported |
| version           | string | N        | set for user and bot messages; used to track versions of your code or to track A/B tests |
| custom_session_id | string | N        | set for user and bot messages; used to define your own custom sessions for Session Flow report and daily session metrics |

## Usage

All methods take the same parameters in the following order - 

```php
$userId, $message, $intent, $version, $customSessionID
```

#### Send a user message to Chatbase

```php
    $send = $chatbase->userMessage($userId, $message, $intent);
    
    // With Facade
    $send = Chatbase::userMessage($userId, $message, $intent)
    
    dd($send);
```

Example Response -

```php
    {#618 ▼
      +"message_id": "2981752682"
      +"status": 200
    }
```

#### Send a user message to Chatbase for a different platform

```php
    $send = $chatbase->setPlatform('slack')->userMessage($userId, $message, $intent);
    
    // With Facade
    $send = Chatbase::setPlatform('slack')->userMessage($userId, $message, $intent)
    
    dd($send);
```

Example Response -

```php
    {#618 ▼
      +"message_id": "2981752682"
      +"status": 200
    }
```

#### Send a user message to Chatbase while logging a version

```php
    $send = $chatbase->userMessage($userId, $message, $intent, $version);
    
    // With Facade
    $send = Chatbase::userMessage($userId, $message, $intent, $version)
    
    dd($send);
```

Example Response -

```php
    {#618 ▼
      +"message_id": "2981752682"
      +"status": 200
    }
```

#### Send failed user message not handled by the bot

```php
    $send = $chatbase->notHandledUserMessage($userId, $message, $intent);
    
    // With Facade
    $send = Chatbase::notHandledUserMessage($userId, $message, $intent);
    
    dd($send);
```

Example Response -

```php
    {#618 ▼
      +"message_id": "29817235682"
      +"status": 200
    }
```

#### Send a bot message sent back to the user with intent

```php
    $send = $chatbase->botMessage($userId, $message, $intent);
    
    // With facade
    $send = Chatbase::botMessage($userId, $message, $intent);
    
    dd($send);
```

Response -

```php
    {#618 ▼
      +"message_id": "29347235682"
      +"status": 200
    }
```

### Working with multiple bots

Sometime you may wish to push your bot activity to different chatbase accounts. Perhaps you have multiple bots running in the one application. You can easily set the `API KEY` for each bot on each method call.

```php
    $send = $chatbase->setApiKey('my-chatbase-api-key')->userMessage($userId, $message, $intent);
    
    // With Facade
    $send = Chatbase::setApiKey('my-chatbase-api-key')->userMessage($userId, $message, $intent)
    
    dd($send);
```

Example Response -

```php
    {#618 ▼
      +"message_id": "2981752682"
      +"status": 200
    }
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email steven@richdynamix.com instead of using the issue tracker.

## Credits

- [Steven Richardson](https://github.com/richdynamix)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
