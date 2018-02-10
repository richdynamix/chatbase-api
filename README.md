#  Chatbase API for PHP and Laravel

Chatbase is a Chatbot analytics service by Google.

This is the unofficial Chatbase API for PHP. It focuses heavily on the Laravel Framework however it will work in any standalone project with usage of Composer. 

## Installation

This package can be installed through Composer.

``` bash
composer require richdynamix/chatbase-api
```

### Framework Agnostic Usage

```php

// API KEY and default platoform must be set
$apiKey = '12345-12345-12345';
$platform = 'messenger';
```

```php
// Instantiate a new Chatbase client with the dependency of Guzzle
$client = new \Richdynamix\Chatbase\Service\ChatbaseClient(new \GuzzleHttp\Client());
```

```php
// Instantiate a new FieldManager with the dependency of the API KEY and default platform
$fieldsManager = new \Richdynamix\Chatbase\Entities\FieldsManager($apiKey, $platform);
```

```php
// Instantiate a new GenericMessage with the dependency of the Chatbase client and the FieldsManager
$chatbase = new \Richdynamix\Chatbase\Service\GenericMessage($client, $fieldsManager);
```

```php
// send a user message to chatbase
$send = $chatbase->userMessage()->with(['user_id => '12345', 'message' => 'hello'])->send();

```

### Laravel Usage

In Laravel >5.5 the package will auto register the service provider. In Laravel 5.4 you must install this service provider.

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
    Chatbase::userMessage()->with($data)->send();
```

```php
    Chatbase::notHandledUserMessage()->with($data)->send();
```

```php
    Chatbase::botMessage()->with($data)->send();
```

#### Fields (keys) that can be set using the `with()` method. (Passed as an array)

| field                | type   | required | description |
| -------------------- | ------ | -------- | ----------- |
| user_id              | string | Y        | the ID of the end-user |
| message              | string | N        | the raw message body regardless of type for example a typed-in or a tapped button or tapped image |
| intent               | string | N        | set for user messages only; if not set usage metrics will not be shown per intent; do not set if it is a generic catch all intent, like default fallback, so that clusters of similar messages can be reported |
| version              | string | N        | set for user and bot messages; used to track versions of your code or to track A/B tests |
| custom_session_id    | string | N        | set for user and bot messages; used to define your own custom sessions for Session Flow report and daily session metrics |

## Usage

All methods take the same parameters in the following order - 

```php
$userId, $message, $intent, $version, $customSessionID
```

#### Send a user message to Chatbase

```php
    $send = $chatbase->userMessage()->with(['user_id => '12345', 'message' => 'hello'])->send();
    
    // With Facade
    $send = Chatbase::userMessage()->with(['user_id => '12345', 'message' => 'hello'])->send();
    
    // With helper setters
    $send = Chatbase::userMessage()->withUserId('12345')->withMessage('hello')->send();
    
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
    $send = $chatbase->userMessage()->with([
        'user_id => '12345',
        'message' => 'hello',
        'platform' => 'slack'
    ])->send();
    
    // With Facade
    $send = Chatbase::userMessage()->with([
        'user_id => '12345',
        'message' => 'hello',
        'platform' => 'slack'
    ])->send();
    
    // With helper setters
    $send = Chatbase::userMessage()
        ->setPlatform('slack')
        ->withUserId('12345')
        ->withMessage('hello')
        ->send();
    
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
    $send = $chatbase->userMessage()->with([
            'user_id => '12345',
            'message' => 'hello',
            'version' => '1.2.1'
        ])->send();
        
        
    // With Facade
    $send = Chatbase::userMessage()->with([
        'user_id => '12345',
        'message' => 'hello',
        'version' => '1.2.1'
    ])->send();
    
    
    // With helper setters
    $send = Chatbase::userMessage()
        ->withUserId('12345')
        ->withMessage('hello')
        ->withVersion('1.2.1')
        ->send();
    
    dd($send);
```

Example Response -

```php
    {#618 ▼
      +"message_id": "2981752682"
      +"status": 200
    }
```

#### Send a user message to Chatbase with intent

```php
    $send = $chatbase->userMessage()->with([
        'user_id => '12345',
        'message' => 'hello',
        'intent' => 'hotel-booking'
    ])->send();
        
        
    // With Facade
    $send = Chatbase::userMessage()->with([
        'user_id => '12345',
        'message' => 'hello',
        'intent' => 'hotel-booking'
    ])->send();
    
    
    // With helper setters
    $send = Chatbase::userMessage()
        ->withUserId('12345')
        ->withMessage('hello')
        ->withIntent('hotel-booking')
        ->send();
    
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
    $send = $chatbase->notHandledUserMessage()
        ->with([
            'user_id => '12345',
            'message' => 'hello',
        ])
        ->send();
    
    // With Facade
    $send = Chatbase::notHandledUserMessage()
        ->with([
          'user_id => '12345',
          'message' => 'hello',
        ])
        ->send();
    
    // With helper setters
    $send = Chatbase::userMessage()
        ->withUserId('12345')
        ->withMessage('hello')
        ->withIntent('hotel-booking')
        ->send();
        
    dd($send);
```

Example Response -

```php
    {#618 ▼
      +"message_id": "29817235682"
      +"status": 200
    }
```

#### Send a bot message sent back to the user

```php
    $send = $chatbase->botMessage()->with(['user_id => '12345','message' => 'hello'])->send();
    
    // With facade
    $send = Chatbase::botMessage()->with(['user_id => '12345','message' => 'hello'])->send();
    
    // With helper setters
    $send = Chatbase::botMessage()->withUserId('12345')->withMessage('hello')->send();
    
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
    $send = $chatbase->userMessage()->with([
        'api_key' => 'my-chatbase-api-key',
        'user_id => '12345',
        'message' => 'hello'
    ])->send();


    // With facade
    $send = Chatbase::userMessage()->with([
        'api_key' => 'my-chatbase-api-key',
        'user_id => '12345',
        'message' => 'hello'
    ])->send();
    
    
    // With helper setters
    $send = Chatbase::botMessage()->setApiKey('my-chatbase-api-key')->withUserId('12345')->withMessage('hello')->send();
    
    dd($send);
```

Example Response -

```php
    {#618 ▼
      +"message_id": "2981752682"
      +"status": 200
    }
```

***Please Note: Invalid fields sent to Chatbase may result in a successful entry however, you will receive a 400 error and a `WrongDataSet` exception will be thrown. This is common when you set fields like `intent` for bot messages.**

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
