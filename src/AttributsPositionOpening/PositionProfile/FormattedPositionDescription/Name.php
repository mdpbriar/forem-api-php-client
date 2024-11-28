<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescription;

class Name
{

    const ACCEPTED_VALUES = ["jobDescription", "contractInformation", "companyPromotionalText"];

    public string $name;

    public function __construct(
        string $name
    )
    {
        $this->setName($name);
    }

    private function setName(string $name): void
    {
        if (!in_array($name, self::ACCEPTED_VALUES)){
            throw new \UnexpectedValueException("Le nom {$name} n'est pas valide pour ce champ");
        }
        $this->name = $name;
    }

    public function getNameArray(): array
    {
        return [
            'Name' => $this->name,
        ];
    }
}