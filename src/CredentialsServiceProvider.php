<?php

namespace LaravelSecretEnv;

use Exception;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class CredentialsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/credentials.php' => __DIR__ . '/../../../../config/credentials.php',
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../config/credentials.php', 'credentials');

        // Update configuration strings
        if (method_exists(app(), 'configurationIsCached') && !app()->configurationIsCached()) {
            $this->fixConfig();
        }
    }

    /**
     * Fix the configuration.
     *
     * @return void
     */
    protected function fixConfig()
    {
        collect(Arr::dot(config()->all()))->filter(function ($item) {
            return is_string($item) && Str::startsWith($item, Credentials::CONFIG_PREFIX);
        })->map(function ($item, $key) {
            $item = Str::replaceFirst(Credentials::CONFIG_PREFIX, '', $item);

            config()->set($key, credentials($item));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('command.credentials.key-generate', CredentialsKeyGenerate::class);
        $this->app->bind(Credentials::class, function () {
            if (!$key = config('credentials.key')) {
                $key = file_exists(config('credentials.key_file'))
                    ? 'base64:' . file_get_contents(config('credentials.key_file'))
                    : null;
            }

            if (!$key) {
                throw new Exception('Credentials key is not specified');
            }
            // If the key starts with "base64:", we will need to decode the key before handing
            // it off to the encrypter. Keys may be base-64 encoded for presentation and we
            // want to make sure to convert them back to the raw bytes before encrypting.
            if (Str::startsWith($key, 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            $encrypter = new Encrypter($key, config('credentials.cipher'));

            return new Credentials($encrypter);
        });

        $this->app->bind('command.credentials.edit', EditCredentialsCommand::class);

        $this->commands([
            'command.credentials.edit',
            'command.credentials.key-generate'
        ]);
    }
}
