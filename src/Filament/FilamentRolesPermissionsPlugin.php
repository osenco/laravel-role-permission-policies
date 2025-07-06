<?php

namespace Spatie\Permission\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentRolesPermissionsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-roles-permissions-policies';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources(
                config('filament-roles-permissions-policies.resources')
            );
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
