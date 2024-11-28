<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\RemunerationPackage\BasePay;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\RemunerationPackage\Benefits;

class RemunerationPackage
{
    public BasePay $basePay;
    public ?Benefits $benefits = null;

    public function __construct(
        array $remunerationPackage,
    )
    {
        if (isset($remunerationPackage['basePayAmountMin'], $remunerationPackage['basePayAmountMax'])){
            $this->basePay = new BasePay(
                basePayAmountMin: $remunerationPackage['basePayAmountMin'],
                basePayAmountMax: $remunerationPackage['basePayAmountMax'],
                currencyCode: $remunerationPackage['currencyCode'] ?? null,
                baseInterval: $remunerationPackage['baseInterval'] ?? null,
            );
        }
        if (isset($remunerationPackage['benefits'])){
            $this->benefits = new Benefits($remunerationPackage['benefits']);
        }
    }


    public function getArray(): array
    {
        $array = [];
        if ($this->basePay){
            $array = array_merge($array, $this->basePay->getArray());
        }
        if ($this->benefits){
            $array = array_merge($array, $this->benefits->getArray());
        }

        return [
            'RemunerationPackage' => $array,
        ];
    }
}