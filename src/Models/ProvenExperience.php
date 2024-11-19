<?php

namespace Mdpbriar\ForemApiPhpClient\Models;

class ProvenExperience extends BaseModel
{
    protected static string $file = 'romeV3';

    public static function getValues(): array
    {
        $values = array_merge(RomeV3::getJson()['values'], Dimeco::getJson()['values']);
        if (count(static::$include) > 0){
            $values = array_filter($values, function ($value){
                return in_array($value["id"], static::$include, true);
            });
        }
        return $values;
    }
}