<?php

namespace Spatie\Permission\Filament\Resources\PermissionResource\Pages;

use Spatie\Permission\Filament\Resources\PermissionResource;
use Spatie\Permission\Filament\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();

        return config('filament-spatie-roles-permissions.should_redirect_to_index.permissions.after_create', false)
            ? $resource::getUrl('index')
            : parent::getRedirectUrl();
    }
}
