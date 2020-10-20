<p align="center" style="padding-bottom:1rem"><img src="https://res.cloudinary.com/markos-nikolaos-orfanos/image/upload/c_scale,h_120,w_120/v1586943534/Sigmie/black-transparent_i6bbix.png"></p>

<p align="center">
<a href="https://github.com/sigmie/crawler/actions?query=workflow%3ABuild">
<img alt="GitHub Workflow Status" src="https://img.shields.io/github/workflow/status/sigmie/crawler/Build">
</a>

<a href="https://codecov.io/gh/sigmie/crawler">
  <img alt="Codecov" src="https://img.shields.io/codecov/c/github/sigmie/crawler">
</a>

<a href="https://packagist.org/packages/sigmie/crawler">
  <img src="https://img.shields.io/packagist/v/sigmie/crawler" alt="version"/>
</a>

<a href="https://packagist.org/packages/sigmie/crawler">
  <img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="License"/>
</a>

</p>

# Crawler

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.


## Install

Via Composer

``` bash
$ composer require sigmie/crawler
```

## Usage

```bash
$ docker run -it -e "CONFIG=$(cat /path/to/your/config.json | jq -r tostring)" sigmie/crawler
```

Config example:

``` json
{
    "start_url": "https://docs.sigmie.com",
    "format": "basic",
    "export": {
        "format": "json",
        "path": "./foo.json"
    },
    "navigation_selector": ".sidebar-links",
    "content_selector": ".content__default"
}
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email nico@sigmie.com instead of using the issue tracker.

## Credits

- [Nicoorfi][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-packagist]: https://packagist.org/packages/sigmie/crawler
[link-travis]: https://travis-ci.org/sigmie/crawler
[link-scrutinizer]: https://scrutinizer-ci.com/g/sigmie/crawler/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/sigmie/crawler
[link-downloads]: https://packagist.org/packages/sigmie/crawler
[link-author]: https://github.com/nicoorfi
[link-contributors]: ../../contributors
