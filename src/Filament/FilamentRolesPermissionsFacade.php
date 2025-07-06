<?php

namespace Osen\Permission\Filament;

use Illuminate\Support\Facades\Facade;

class FilamentRolesPermissionsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'FilamentRolesPermissions';
    }
}
