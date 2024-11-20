<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\FormattedPositionDescription;

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
            "__custom:FormattedPositionDescription:{$this->name->name}" => [
                ...$this->name->getNameArray(),
                ...$this->value->getArrayValue(),
            ]
        ];
    }

}