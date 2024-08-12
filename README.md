# Glimpse

Easily spot missing authorization checks in Laravel

## Features

Mark usages of a variety of different Blade directives on the page, so you can spot missing authorization/auth/env guards

Supported directives:

- `@can`, `@cannot`, `@canany`
- `@env`, `@production`
- `@auth`, `@guest`

<!-- TODO: Display any authorization & authentication middlewares applied page (or any auth/policy check before blade renders), so you can easily spot if the current route doesn't apply appropriate guards -->

## Configuration

```php
[
    'enabled' => env('GLIMPSE_ENABLED', app()->isLocal()),

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
]
```

## Development

```bash
composer lint # run all linters
composer fix # run all fixers

composer analyze # run static analysis
composer baseline # generate static analysis baseline

composer test # run test suite
composer build # bundle all assets
```

- [x] BladeCanStatementsTest
- [x] BladeCananyStatementsTest
- [x] BladeCannotStatementsTest
- [x] BladeIfAuthStatementsTest
- [x] BladeElseAuthStatementsTest
- [x] BladeEnvironmentStatementsTest
- [x] BladeIfGuestStatementsTest
- [x] BladeElseGuestStatementsTest
