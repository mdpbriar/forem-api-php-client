<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

class NumberToFill
{

    public int $numberToFill;
    public function __construct(int $numberToFill)
    {
        $this->numberToFill = $numberToFill;
    }

    public function getArray(): array
    {
        return [
            'NumberToFill' => $this->numberToFill
        ];
    }
}