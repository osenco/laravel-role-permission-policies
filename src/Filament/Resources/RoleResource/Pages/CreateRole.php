<?php

namespace Osen\Permission\Filament\Resources\RoleResource\Pages;

use Osen\Permission\Filament\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();

        return config('filament-roles-permissions-policies.should_redirect_to_index.roles.after_create', false)
            ? $resource::getUrl('index')
            : parent::getRedirectUrl();
    }
}
