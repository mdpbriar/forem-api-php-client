<?php

namespace Mdpbriar\ForemApiPhpClient;

class ValidateOptions
{

    public static function validateArrayFields(array $options, array $required_fields): void
    {
        foreach ($required_fields as $required_field){

            if (!isset($options[$required_field])){
                throw new \InvalidArgumentException("L'option '{$required_field}' n'est pas définie");
            }
        }
    }
}