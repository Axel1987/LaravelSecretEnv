## Installation

You can install the package via composer:

```bash
composer require beyondcode/laravel-credentials
```

The package will automatically register itself.

You can optionally publish the configuration with:

```bash
php artisan vendor:publish --provider="LaravelSecretEnv\CredentialsServiceProvider" --tag="config"
``` 

This is the content of the published config file:

```php
<?php

return [

    /*
     * Defines the file that will be used to store and retrieve the credentials.
     */
    'file' => config_path('credentials.php.enc'),

    /*
     * Defines the key that will be used to encrypt / decrypt the credentials.
     * The default is your application key. Be sure to keep this key secret!
     */
    'key' => config('app.key'),

    'cipher' => config('app.cipher'),

];
```


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
