<?php

use LaravelSecretEnv\Credentials;
use Illuminate\Contracts\Container\BindingResolutionException;

if (! function_exists('cred')) {
    /**
     * Get a an encrypted value.
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
    function cred(string $key, $default = null)
    {
        $filename = config('credentials.file');
        try {
            $credentials = app(Credentials::class);
            $credentials->load($filename);

            return $credentials->get($key, $default);

        } catch (ReflectionException | BindingResolutionException $e) {

            return Credentials::CONFIG_PREFIX . $key;

        }

    }
}
