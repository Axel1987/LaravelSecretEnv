<?php

return [

    /*
     * Defines the file that will be used to store and retrieve the credentials.
     */
    'file' => __DIR__ . ('/credentials.php.enc'),

    /*
     * Defines the key that will be used to encrypt / decrypt the credentials.
     * The default is your application key. Be sure to keep this key secret!
     *
     * WARNING:: Need to use 1 of key option. Not used options must be 'null' or commented
     */
//    'key' => config('app.key'),
    'key_file' => storage_path('cred.key'),

    /**
     * 'AES-128-CBC','AES-256-CBC',AES-128-GCM',AES-256-GCM';
     */
    'cipher' => 'AES-256-CBC',

    'editor' => env('EDITOR', 'nano')
];
