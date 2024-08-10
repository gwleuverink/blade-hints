<?php

return [
    'enabled' => env('GLIMPSE_ENABLED', app()->isLocal()),

    'authorization_directives_enabled' => true,
    'authorization_if_color' => '#fca5a5', // red-300
    'authorization_else_color' => '#d8b4fe', // purple-300
];
