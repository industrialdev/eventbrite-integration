# Eventbrite Integration

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-circle]

Library for integration of the EventBrite API v3 with multiple applications,
fine tuned for Event Registration.

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practises by being named the following.

```
bin/        
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require industrialdev/eventbrite-integration
```

## Usage

* Make sure to create a `.env` file at the root of this project to create the
  necessary environment variables to access the API.

``` php
<?php
require_once "vendor/autoload.php";
use Industrialdev\Eventbrite\Eventbrite;

$eventbrite = new Eventbrite();
$events = $eventbrite->getEvents('me');

print_r($events);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email devteam@industrialagency.ca instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/industrialdev/eventbrite-integration.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/industrialdev/eventbrite-integration/master.svg?style=flat-square
[ico-circle]: https://circleci.com/gh/industrialdev/eventbrite-integration.svg?style=shield&circle-token=:circle-token

[link-packagist]: https://packagist.org/packages/industrialdev/eventbrite-integration
[link-travis]: https://travis-ci.org/industrialdev/eventbrite-integration
[link-circle]: https://circleci.com/gh/industrialdev/eventbrite-integration
[link-scrutinizer]: https://scrutinizer-ci.com/g/industrialdev/eventbrite-integration/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/industrialdev/eventbrite-integration
[link-downloads]: https://packagist.org/packages/industrialdev/eventbrite-integration
[link-author]: https://github.com/industrialdev
[link-contributors]: ../../contributors
