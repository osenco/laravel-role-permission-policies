<?php

namespace Spatie\Permission\Filament;

use Spatie\Permission\Filament\Commands\Permission;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentRolesPermissionsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-spatie-roles-permissions';

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-spatie-roles-permissions')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasCommand(Permission::class);
    }
}
