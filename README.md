# Laravel 8.0+ Translation Helper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/boblarouche/traduction.svg?style=flat-square)](https://packagist.org/packages/boblarouche/traduction)
[![Build Status](https://img.shields.io/travis/boblarouche/traduction/master.svg?style=flat-square)](https://travis-ci.org/boblarouche/traduction)
[![Quality Score](https://img.shields.io/scrutinizer/g/boblarouche/traduction.svg?style=flat-square)](https://scrutinizer-ci.com/g/boblarouche/traduction)
[![Total Downloads](https://img.shields.io/packagist/dt/boblarouche/traduction.svg?style=flat-square)](https://packagist.org/packages/boblarouche/traduction)

This package copies Laravel translation entries of default language located in `resources/lang/xx` to a new target language. By default, it adds missing target keys only, but it can also replace everything. Different outputs and a sort option are available.

## Installation

You can install the package via composer:

``` bash
composer require boblarouche/traduction
```
This package uses your app's fallback_locale configured at `config/app.php` as the default language.

## Usage

``` bash
php artisan translation:missing
```
Here are different examples with optional parameters:
``` bash
php artisan translation:missing --target=fr --output=key 
php artisan translation:missing --target=es --output=value --replace
php artisan translation:missing --target=it --output=value --replace --sort
```

## Options

If no options are specify, the artisan command will prompt the user in terminal. Add *target* and *output* options to skip all prompts.

 - **Target language** `--target=fr` [no default]
 - **Output type**: `--output=value` will copy default language text for each new entry of target language and `--output=key` will use the keys as text. [*value* is default]
 - **Replace all** `--replace` will overwrite any existing translation in target language. *Beware: This is Destructive!* [*false* is default]
 - **Sorting** `--sort` will put all target keys in aphabetical order [*false* is default]

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Future updates/TODO:

- Add auto-translation from external service output e.g. --output=google-translate.

## Credits

* [Bob Larouche](https://github.com/boblarouche)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
