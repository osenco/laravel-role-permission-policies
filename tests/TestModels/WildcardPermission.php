<?php

namespace Osen\Permission\Tests\TestModels;

use Osen\Permission\WildcardPermission as BaseWildcardPermission;

class WildcardPermission extends BaseWildcardPermission
{
    /** @var string */
    public const WILDCARD_TOKEN = '@';

    /** @var non-empty-string */
    public const PART_DELIMITER = ':';

    /** @var non-empty-string */
    public const SUBPART_DELIMITER = ';';
}
