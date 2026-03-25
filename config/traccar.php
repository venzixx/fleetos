<?php

return [
    'url' => env('TRACCAR_URL', 'http://localhost:8082'),
    'user' => env('TRACCAR_USER', 'admin'),
    'password' => env('TRACCAR_PASSWORD', 'admin'),
    'poll_interval' => env('TRACCAR_POLL_INTERVAL', 10),
];
