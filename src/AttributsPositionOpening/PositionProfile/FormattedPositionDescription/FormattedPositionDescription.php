<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescription;

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

    public function getArray(): array
    {
        return [
            "__custom:FormattedPositionDescription:{$this->name->name}" => [
                ...$this->name->getArray(),
                ...$this->value->getValue(),
            ]
        ];
    }

}