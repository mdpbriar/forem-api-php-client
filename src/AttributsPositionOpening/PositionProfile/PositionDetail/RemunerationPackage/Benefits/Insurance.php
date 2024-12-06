<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\RemunerationPackage\Benefits;

class Insurance
{

    protected string $insurance;
    public function __construct(
        string $insurance
    )
    {
        $this->setOptions($insurance);
    }

    private function setOptions(string $insurance): void
    {
        $this->insurance = $insurance;
    }

    public function getArray(): array
    {
        return [
            "__custom:Insurance:{$this->insurance}" => [
                '_attributes' => [
                    'type' => $this->insurance
                ],
                '_value' => 'true'
            ]
        ];

    }

}