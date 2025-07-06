<?php

namespace Spatie\Permission\Filament\Resources\RoleResource\Pages;

use Spatie\Permission\Filament\Resources\RoleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    public function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        $resource = static::getResource();

        return config('filament-roles-permissions-policies.should_redirect_to_index.roles.after_create', false)
            ? $resource::getUrl('index')
            : parent::getRedirectUrl();
    }
}
