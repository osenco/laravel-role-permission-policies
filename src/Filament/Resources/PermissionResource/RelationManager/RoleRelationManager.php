<?php

namespace Spatie\Permission\Filament\Resources\PermissionResource\RelationManager;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RoleRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $recordTitleAttribute = 'name';

    protected static function getModelLabel(): string
    {
        return __('filament-roles-permissions-policies::filament-spatie.section.role');
    }

    protected static function getPluralModelLabel(): string
    {
        return __('filament-roles-permissions-policies::filament-spatie.section.roles');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('filament-roles-permissions-policies::filament-spatie.field.name')),
                TextInput::make('guard_name')
                    ->label(__('filament-roles-permissions-policies::filament-spatie.field.guard_name'))
                    ->visible(fn () => config('filament-roles-permissions-policies.should_show_guard', true)),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // Support changing table heading by translations.
            ->heading(__('filament-roles-permissions-policies::filament-spatie.section.roles'))
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label(__('filament-roles-permissions-policies::filament-spatie.field.name')),
                TextColumn::make('guard_name')
                    ->searchable()
                    ->label(__('filament-roles-permissions-policies::filament-spatie.field.guard_name'))
                    ->visible(fn () => config('filament-roles-permissions-policies.should_show_guard', true)),
            ])
            ->filters([
                //
            ]);
    }
}
