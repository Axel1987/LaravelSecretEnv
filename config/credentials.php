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
//    'key' => config('app.key'),
    'key_file' => storage_path('cred.key'),

    'cipher' => config('app.cipher'),

    'editor' => env('EDITOR', 'nano')
];
