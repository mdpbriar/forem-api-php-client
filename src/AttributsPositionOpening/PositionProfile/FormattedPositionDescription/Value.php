<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescription;

class Value
{
    protected string $value;

    public function __construct(
        string $value,
    )
    {
        $this->setValue($value);
    }

    private function setValue(string $value): void
    {
        $this->value = $value;
    }


    public function getValue(): array
    {
        return [
            'Value' => [
                '_cdata' => $this->value
            ],
        ];
    }


}