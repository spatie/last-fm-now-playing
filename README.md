# Get the currently playing track from a last.fm user

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/last-fm-now-playing.svg?style=flat-square)](https://packagist.org/packages/spatie/last-fm-now-playing)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/last-fm-now-playing/master.svg?style=flat-square)](https://travis-ci.org/spatie/last-fm-now-playing)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/af13f9b5-e8a9-4a7d-a97d-46b9d4aa86a4.svg?style=flat-square)](https://insight.sensiolabs.com/projects/af13f9b5-e8a9-4a7d-a97d-46b9d4aa86a4)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/last-fm-now-playing.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/last-fm-now-playing)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/last-fm-now-playing.svg?style=flat-square)](https://packagist.org/packages/spatie/last-fm-now-playing)

This package contains a class to determine the curren track a specified user is playing according to last.fm

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Installation

You can install the package via composer:

``` bash
composer require spatie/last-fm-now-playing
```

## Usage

The constructor of `Spatie\NowPlaying\NowPlaying` needs an api key you can get [from the last.fm site](http://www.last.fm/api/account/create).

``` php
$nowPlaying = Spatie\NowPlaying\NowPlaying($apiKey);

$nowPlaying->getTrackInfo($lastFmUserName);
```

If the specified user is currently playing a track you'll get backy and array with keys `artist`, `trackName` and `artwork`. The `getTrackInfo`-function will return `false` when a user is not currently playing a track.

If something goes wrong an instance of `Spatie\NowPlaying\Exceptions\BadResponse` will be thrown.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
