<?php

namespace Osen\Permission\Tests\TestModels;

class RuntimeRole extends \Osen\Permission\Models\Role
{
    protected $visible = [
        'id',
        'name',
    ];
}
