# Create backend driven navigation routes with server-side authorization in Laravel.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/honed/nav.svg?style=flat-square)](https://packagist.org/packages/honed/nav)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/honedlabs/nav/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/honed/nav/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/honedlabs/nav/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/honed/nav/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/honed/nav.svg?style=flat-square)](https://packagist.org/packages/honed/nav)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require honed/nav
```

## Usage
Interact with the `Nav` facade to create navigation items.

```php
Nav::items(NavItem::make('Home', '/'), NavItem::make('About', '/about'), NavItem::make('Contact', '/contact'));
```

You can create groups of navigation items, allowing you to select which ones to send to the page on render. By default, if you don't specify a group, the items will be added to the `default` group.

```php
Nav::group('main', [
    NavItem::make('Home', '/'),
    NavItem::make('About', '/about'),
    NavItem::make('Contact', '/contact'),
]);
Nav::use('main');
```

You can use the `SharesNavigation` middleware to share the navigation items with the page automatically using merged props. This will append the navigation items to the page props using the `nav` key. If you want to simplify this, you can use the client-side composable [`useNavigation`](https://github.com/honedlabs/nav-client) to handle this automatically and provide the necessary interfaces. See the documentation for the client package for more information.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Joshua Wallace](https://github.com/jdw5)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
