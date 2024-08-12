<?php

return [
    'enabled' => env('BLADE_HINTS_ENABLED', app()->isLocal()),

    'authorization_directives' => true,
    'authorization_if_color' => '#fca5a5', // red-300
    'authorization_else_color' => '#d8b4fe', // purple-300

    'authentication_directives' => true,
    'authentication_if_color' => '#fca5a5', // red-300
    'authentication_else_color' => '#d8b4fe', // purple-300

    'environment_directives' => true,
    'environment_if_color' => '#fca5a5', // red-300

    'guest_directives' => true,
    'guest_if_color' => '#fca5a5', // red-300
];
