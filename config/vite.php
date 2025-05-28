<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Vite Asset Manifest
    |--------------------------------------------------------------------------
    |
    | This option defines the location of the Vite manifest file, which
    | provides a mapping between your compiled assets and their URIs.
    |
    */

    'manifest' => public_path(env('VITE_MANIFEST_PATH', 'build/manifest.json')),

    /*
    |--------------------------------------------------------------------------
    | Vite Dev Server URL (for local dev)
    |--------------------------------------------------------------------------
    |
    | This URL is used to load assets from the Vite dev server.
    |
    */

    'dev_server_url' => env('VITE_DEV_SERVER_URL', 'http://localhost:5173'),

];
