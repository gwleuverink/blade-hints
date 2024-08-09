# Glimpse

Easily spot missing authorization checks in Laravel

## Features

- Display usages of `@can`, `@cannot` & `@canany` directives, so you can spot missing authorization guards
- Display any authorization & authentication middlewares applied page (or any auth/policy check before blade renders), so you can easily spot if the current route doesn't apply appropriate guards

## Development

```bash
composer lint # run all linters
composer fix # run all fixers

composer analyze # run static analysis
composer baseline # generate static analysis baseline

composer test # run test suite
```
