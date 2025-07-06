<div align="left">
    <a href="https://spatie.be/open-source?utm_source=github&utm_medium=banner&utm_campaign=laravel-permission">
      <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://spatie.be/packages/header/laravel-permission/html/dark.webp">
        <img alt="Logo for laravel-permission" src="https://spatie.be/packages/header/laravel-permission/html/light.webp">
      </picture>
    </a>

<h1>Associate users with permissions, roles and policies</h1>
    
</div>

## Documentation, Installation, and Usage Instructions

See the [documentation](https://osenco.github.io/laravel-role-permission-policies/) for detailed installation and usage instructions.

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

## Credits

- [Chris Brown](https://github.com/drbyte)
- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
