<?php

namespace Osen\Permission\Tests\TestModels;

use Osen\Permission\Traits\HasRoles;

class User extends UserWithoutHasRoles
{
    use HasRoles;
}
