<?php

namespace Osen\Permission\Filament\Concerns;

use Osen\Permission\Traits\HasRoles;

trait HasSuperAdmin
{
    use HasRoles;

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(config('filament-roles-permissions-policies.super_admin_role_name', 'Super Admin'));
    }
}
