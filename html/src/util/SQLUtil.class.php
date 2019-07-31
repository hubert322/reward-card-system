<?php
declare (strict_types=1);

namespace util;

class SQLUtil
{
    static function escapeString (string $parameter): string
    {
        return addslashes ($parameter);
    }
}