<?php

namespace Osen\Permission\Filament\Resources\PermissionResource\Pages;

use Osen\Permission\Filament\Resources\PermissionResource;
use Osen\Permission\Filament\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();

        return config('filament-roles-permissions-policies.should_redirect_to_index.permissions.after_create', false)
            ? $resource::getUrl('index')
            : parent::getRedirectUrl();
    }
}
