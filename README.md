<div align="left">
    <a href="https://osen.be/open-source?utm_source=github&utm_medium=banner&utm_campaign=laravel-permission">
      <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://osen.be/packages/header/laravel-permission/html/dark.webp">
        <img alt="Logo for laravel-permission" src="https://osen.be/packages/header/laravel-permission/html/light.webp">
      </picture>
    </a>

<h1>Associate users with permissions and roles</h1>
    
</div>

## Documentation, Installation, and Usage Instructions

See the [documentation](https://osen.be/docs/laravel-permission/) for detailed installation and usage instructions.

## What It Does
This package allows you to manage user permissions and roles in a database.

Once installed you can do stuff like this:

```php
// Adding permissions to a user
$user->givePermissionTo('edit articles');

// Adding permissions via a role
$user->assignRole('writer');

$role->givePermissionTo('edit articles');
```

Because all permissions will be registered on [Laravel's gate](https://laravel.com/docs/authorization), you can check if a user has a permission with Laravel's default `can` function:

```php
$user->can('edit articles');
```

## Installation

```bash
composer require osenco/laravel-role-permission-policies
```

## Filament

Please see [FILAMENT](FILAMENT.md) for how to setup on Filament.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/osenco/.github/blob/main/CONTRIBUTING.md) for details.

### Testing

``` bash
composer test
```

### Security

If you discover any security-related issues, please email [security@osen.be](mailto:security@osen.be) instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Osen, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://osen.be/en/opensource/postcards).

## Credits

- [Chris Brown](https://github.com/drbyte)
- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

This package is heavily based on [Jeffrey Way](https://twitter.com/jeffrey_way)'s awesome [Laracasts](https://laracasts.com) lessons
on [permissions and roles](https://laracasts.com/series/whats-new-in-laravel-5-1/episodes/16). His original code
can be found [in this repo on GitHub](https://github.com/laracasts/laravel-5-roles-and-permissions-demo).

Special thanks to [Alex Vanderbist](https://github.com/AlexVanderbist) who greatly helped with `v2`, and to [Chris Brown](https://github.com/drbyte) for his longtime support  helping us maintain the package.

Special thanks to [Caneco](https://twitter.com/caneco) for the original logo.

## Alternatives

- [Povilas Korop](https://twitter.com/@povilaskorop) did an excellent job listing the alternatives [in an article on Laravel News](https://laravel-news.com/two-best-roles-permissions-packages). In that same article, he compares laravel-permission to [Joseph Silber](https://github.com/JosephSilber)'s [Bouncer]((https://github.com/JosephSilber/bouncer)), which in our book is also an excellent package.
- [santigarcor/laratrust](https://github.com/santigarcor/laratrust) implements team support
- [ultraware/roles](https://github.com/ultraware/roles) (archived) takes a slightly different approach to its features.
- [zizaco/entrust](https://github.com/zizaco/entrust) offers some wildcard pattern matching

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
