#  Chatbase API for Laravel

This is the unofficial Laravel Chatbase API SDK. Chatbase is a Chatbot analytics service by Google.

**HELP WANTED**

I have started this project to accomodate my own needs. Development is pretty much on an AdHoc basis however I recognise there is far more features required for this project. If you have spare time and would like to contribute then please feel free.

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

In Laravel >5.5 the package will autoregister the facades. In Laravel 5.4 you must install the facade manually.

```php
// config/app.php
'aliases' => [
    ...
    'CbMessage' => Richdynamix\Chatbase\Facades\CbMessage::class,
    ...
];
```

Optionally, you can publish the config file of this package with this command:

``` bash
php artisan vendor:publish --providesr="Richdynamix\Chatbase\ChatbaseServiceProvider"
```

The following config file will be published in `config/chatbase.php`

```php
return [
    'api_key' => env('CHATBASE_API_KEY'),
];
```

## Usage


## Testing

Run the tests with:

``` bash
vendor/bin/phpunit
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
