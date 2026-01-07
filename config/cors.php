<?php

return [
    /*
    | SOP: Membuka gerbang akses untuk Vercel (Frontend)
    */
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'public/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'], // Mengizinkan semua akses luar (Vercel)

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Izinkan semua header (termasuk kunci ngrok)

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];