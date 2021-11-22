<?php

namespace LaravelSecretEnv;

use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Symfony\Component\Process\Process;
use LaravelSecretEnv\Exceptions\InvalidJSON;


/**
 * Class CredentialsKeyGenerate
 */
class CredentialsKeyGenerate extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'credentials:key-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a key file or key string for a credenrials';

    /**
     * The command handler.
     */
    public function handle()
    {
        $cipher = config('credentials.cipher', 'AES-128-CBC');
        $key = Encrypter::generateKey($cipher);

        $base64 = base64_encode($key);

        if (config('credentials.key')) {
            echo "Please put this key to config file " . PHP_EOL .  $base64 . PHP_EOL;
        }else {
            $path = config('credentials.key_file');
            file_put_contents($path, $base64);

            echo 'Done' . PHP_EOL;
        }
    }
}