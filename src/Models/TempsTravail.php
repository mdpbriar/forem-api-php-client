<?php

namespace Mdpbriar\ForemApiPhpClient\Models;

class TempsTravail extends BaseModel
{
    protected static string $file = 'tempstravail';

    public const REGIMES_TRAVAIL = ['Full Time', 'Part Time'];

    public static function getRegimesTravailOptions(): array
    {
        return self::getOptions(self::REGIMES_TRAVAIL);
    }

    public static function getHorairesTravailOptions(): array
    {
        $options = self::getOptions();
        return array_filter($options, function($key){
           return !in_array($key, self::REGIMES_TRAVAIL, true);
        }, ARRAY_FILTER_USE_KEY);
    }

}