<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\FormattedPositionDescription\Name;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\FormattedPositionDescription\Value;

class FormattedPositionDescription
{
    protected Name $name;
    protected Value $value;

    public function __construct(
        array $formattedDescription
    )
    {
        $this->name = new Name($formattedDescription['name']);
        $this->value = new Value($formattedDescription['value']);
    }

    public function getFormattedDescriptionArray(): array
    {
        return [
            'FormattedPositionDescription' => [
                ...$this->name->getNameArray(),
                ...$this->value->getArrayValue(),
            ]
        ];
    }

}