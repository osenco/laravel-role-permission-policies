<?php

namespace Osen\Permission\Filament;

use Osen\Permission\Filament\Commands\Permission;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentRolesPermissionsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-roles-permissions-policies';

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-roles-permissions-policies')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasCommand(Permission::class);
    }
}
