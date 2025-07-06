<?php

namespace Osen\Permission\Exceptions;

use InvalidArgumentException;

class WildcardPermissionNotImplementsContract extends InvalidArgumentException
{
    public static function create()
    {
        return new static(__('Wildcard permission class must implement Osen\\Permission\\Contracts\\Wildcard contract'));
    }
}
