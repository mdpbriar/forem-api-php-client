<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\RemunerationPackage\Benefits;

class OtherBenefit
{

    protected string $benefit;
    public function __construct(
        string $benefit
    )
    {
        $this->setOptions($benefit);
    }

    private function setOptions(string $benefit): void
    {
        $this->benefit = $benefit;
    }

    public function getArray(): array
    {
        return [
            "__custom:OtherBenefits:{$this->benefit}" => [
                '_attributes' => [
                    'type' => $this->benefit
                ],
                '_value' => 'true'
            ]
        ];

    }

}