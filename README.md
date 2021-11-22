## Installation

You can install the package via composer:

```bash
composer require axel-dzhurko/laravel-secret-env
```

The package will automatically register itself.

You can optionally publish the configuration with:

```bash
php artisan vendor:publish --provider="LaravelSecretEnv\CredentialsServiceProvider" --tag="config"
``` 

## Lumen instalation

In `bootstrap/app` need register provider
```
$app->register(\LaravelSecretEnv\CredentialsServiceProvider::class);
```

Publish config file use command
```
cp vendor/axel-dzhurko/laravel-secret-env/config/credentials.php config/credentials.php
```

### This is the content of the published config file:

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
     *
     * WARNING:: Need to use 1 of key option. Not used options must be 'null' or commented
     */
    'key' => config('app.key'),
    'key_file' => storage_path('cred.key'),

    'cipher' => config('app.cipher'),

    'editor' => env('EDITOR', 'nano')
];
```
> NOTE:: Editor application must be installed in Docker image or in your system in pure installation case

Generate key / key file
```
php artisan credentials:key-generate
```
if you use 'config.key' - you will get a key-string for config
if you use 'config.key_file' - key file will generate according path in config

## Usage

Set secret variable

```bash
 php artisan credentials:edit
```

For a use secret in code
```
cred('some.var_name')
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
