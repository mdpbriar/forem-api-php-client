<?php

namespace Mdpbriar\ForemApiPhpClient\Models;

class Pays extends BaseModel
{
    protected static string $file = 'pays';

    public static function validateCountryCode(string $code): bool
    {
        return self::isValidId($code);
    }

}