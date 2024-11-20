<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\FormattedPositionDescription;

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
        $this->value = "<![CDATA[{$value}]]>";
    }


    public function getArrayValue(): array
    {
        return [
            'Value' => $this->value,
        ];
    }


}