<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\UserArea;

use Mdpbriar\ForemApiPhpClient\ValidateOptions;

class ActiveMediation
{

    const POSSIBLE_CHOICES = ['O', 'W', 'C', 'B'];
    protected string $region;
    public function __construct(
        array $activeMediation
    )
    {
        $this->setOptions($activeMediation);
    }

    public function setOptions(array $options): void
    {
        // On vérifie que le champ région est bien présent
        $required_fields = ['region'];
        ValidateOptions::validateArrayFields($options, $required_fields);
        $region = $options['region'];
        // On vérifie que région est bien dans les choix possibles
        if (!in_array($region, self::POSSIBLE_CHOICES, true)){
            throw new \UnexpectedValueException("Le champ région ne peut contenir que les valeurs ".implode(', ', self::POSSIBLE_CHOICES ));
        }
        $this->region = $region;

    }

    public function getArray(): array
    {
        return [
            'ActiveMediation' => [
                'Region' => $this->region
            ]
        ];
    }
}