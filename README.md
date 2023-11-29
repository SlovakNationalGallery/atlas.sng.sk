# atlas.sng.sk

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Allow SNG visitors to collect bookmarks during their on-site experience and return to them afterward to keep exploring/learning.

![app screenshots](/resources/img/screenshots.jpg?raw=true)

![photo from the exhibition](/resources/img/exhibition.jpg?raw=true)

## Development

This software is built with the [Laravel framework](http://laravel.com/).

It requires

1. PHP >= 8.0.x
1. MySQL >= 5.7

**Set up** with

1. copy `.env.example` to `.env` and customize
1. `composer install`
1. `npm install`

**Start** with

1. `npm run watch`
1. `php artisan serve`

**Test** with

1. `php artisan test --env=testing`

## API Documentation

The API documentation is generated using [Scribe](https://scribe.knuckles.wtf) using the command

1. `php artisan scribe:generate`

For more details, read the [Scribe documentation](https://scribe.knuckles.wtf/laravel)


## Maintainer

This project is maintained by [lab.SNG](http://lab.sng.sk). If you have any questions please don't hesitate to ask them by creating an issue or email us at [lab@sng.sk](mailto:lab@sng.sk).

## License

Source code in this repository is licensed under the MIT license. Please see the [License File](LICENSE) for more information.
