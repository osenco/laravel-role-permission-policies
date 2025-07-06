<?php

namespace Spatie\Permission\Filament\Resources;

use Spatie\Permission\Filament\Resources\PermissionResource\Pages\CreatePermission;
use Spatie\Permission\Filament\Resources\PermissionResource\Pages\EditPermission;
use Spatie\Permission\Filament\Resources\PermissionResource\Pages\ListPermissions;
use Spatie\Permission\Filament\Resources\PermissionResource\Pages\ViewPermission;
use Spatie\Permission\Filament\Resources\PermissionResource\RelationManager\RoleRelationManager;
use Filament\Facades\Filament;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionResource extends Resource
{
    public static function isScopedToTenant(): bool
    {
        return config('filament-roles-permissions-policies.scope_premissions_to_tenant', config('filament-roles-permissions-policies.scope_to_tenant', true));
    }   

    public static function getNavigationIcon(): ?string
    {
        return  config('filament-roles-permissions-policies.icons.permission_navigation');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('filament-roles-permissions-policies.should_register_on_navigation.permissions', true);
    }

    public static function getModel(): string
    {
        return config('permission.models.permission', Permission::class);
    }

    public static function getLabel(): string
    {
        return __('filament-roles-permissions-policies::filament-spatie.section.permission');
    }

    public static function getNavigationGroup(): ?string
    {
        return __(config('filament-roles-permissions-policies.navigation_section_group', 'filament-roles-permissions-policies::filament-spatie.section.roles_and_permissions'));
    }

    public static function getNavigationSort(): ?int
    {
        return  config('filament-roles-permissions-policies.sort.permission_navigation');
    }

    public static function getPluralLabel(): string
    {
        return __('filament-roles-permissions-policies::filament-spatie.section.permissions');
    }

    public static function getCluster(): ?string
    {
        return config('filament-roles-permissions-policies.clusters.permissions', null);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label(__('filament-roles-permissions-policies::filament-spatie.field.name'))
                                ->required(),
                            Select::make('guard_name')
                                ->label(__('filament-roles-permissions-policies::filament-spatie.field.guard_name'))
                                ->options(config('filament-roles-permissions-policies.guard_names'))
                                ->default(config('filament-roles-permissions-policies.default_guard_name'))
                                ->visible(fn() => config('filament-roles-permissions-policies.should_show_guard', true))
                                ->live()
                                ->afterStateUpdated(fn(Set $set) => $set('roles', null))
                                ->required(),
                            Select::make('roles')
                                ->multiple()
                                ->label(__('filament-roles-permissions-policies::filament-spatie.field.roles'))
                                ->relationship(
                                    name: 'roles',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: function (Builder $query, Get $get) {
                                        if (!empty($get('guard_name'))) {
                                            $query->where('guard_name', $get('guard_name'));
                                        }
                                        if (config('permission.teams', false) && Filament::hasTenancy()) {
                                            return $query->where(config('permission.column_names.team_foreign_key'), Filament::getTenant()->id);
                                        }
                                        return $query;
                                    }
                                )
                                ->preload(config('filament-roles-permissions-policies.preload_roles', true)),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('filament-roles-permissions-policies::filament-spatie.field.name'))
                    ->searchable(),
                TextColumn::make('guard_name')
                    ->toggleable(isToggledHiddenByDefault: config('filament-roles-permissions-policies.toggleable_guard_names.permissions.isToggledHiddenByDefault', true))
                    ->label(__('filament-roles-permissions-policies::filament-spatie.field.guard_name'))
                    ->searchable()
                    ->visible(fn() => config('filament-roles-permissions-policies.should_show_guard', true)),
            ])
            ->filters([
                SelectFilter::make('models')
                    ->label(__('filament-roles-permissions-policies::filament-spatie.field.models'))
                    ->multiple()
                    ->options(function () {
                        $commands = new \Spatie\Permission\Filament\Commands\Permission();

                        /** @var \ReflectionClass[] */
                        $models = $commands->getAllModels();

                        $options = [];

                        foreach ($models as $model) {
                            $options[$model->getShortName()] = $model->getShortName();
                        }

                        return $options;
                    })
                    ->query(function (Builder $query, array $data) {
                        if (isset($data['values'])) {
                            $query->where(function (Builder $query) use ($data) {
                                foreach ($data['values'] as $key => $value) {
                                    if ($value) {
                                        $query->orWhere('name', 'like', eval(config('filament-roles-permissions-policies.model_filter_key')));
                                    }
                                }
                            });
                        }

                        return $query;
                    }),
                SelectFilter::make('guard_name')
                    ->label(__('filament-roles-permissions-policies::filament-spatie.field.guard_name'))
                    ->multiple()
                    ->options(config('filament-roles-permissions-policies.guard_names')),
            ])->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                BulkAction::make('Attach to roles')
                    ->label(__('filament-roles-permissions-policies::filament-spatie.action.attach_to_roles'))
                    ->action(function (Collection $records, array $data): void {
                        Role::whereIn('id', $data['roles'])->each(function (Role $role) use ($records): void {
                            $records->each(fn(Permission $permission) => $role->givePermissionTo($permission));
                        });
                    })
                    ->form([
                        Select::make('roles')
                            ->multiple()
                            ->label(__('filament-roles-permissions-policies::filament-spatie.field.role'))
                            ->options(Role::query()->pluck('name', 'id'))
                            ->required(),
                    ])->deselectRecordsAfterCompletion(),
            ])
            ->emptyStateActions(
                config('filament-roles-permissions-policies.should_remove_empty_state_actions.permissions') ? [] :
                    [
                        Tables\Actions\CreateAction::make()
                    ]
            );
    }

    public static function getRelations(): array
    {
        $relationManagers = [];

        if (config('filament-roles-permissions-policies.should_display_relation_managers.roles', true)) {
            $relationManagers[] = RoleRelationManager::class;
        }

        return $relationManagers;
    }

    public static function getPages(): array
    {
        if (config('filament-roles-permissions-policies.should_use_simple_modal_resource.permissions')) {
            return [
                'index' => ListPermissions::route('/'),
            ];
        }

        return [
            'index' => ListPermissions::route('/'),
            'create' => CreatePermission::route('/create'),
            'edit' => EditPermission::route('/{record}/edit'),
            'view' => ViewPermission::route('/{record}'),
        ];
    }
}
