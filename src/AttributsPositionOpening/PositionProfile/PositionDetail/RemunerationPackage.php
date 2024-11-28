<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\RemunerationPackage\BasePay;

class RemunerationPackage
{
    public BasePay $basePay;

    # TODO : add Benefits

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
    }


    public function getRemunerationPackageArray(): array
    {
        $array = [];
        if ($this->basePay){
            $array = array_merge($array, $this->basePay->getBasePayArray());
        }

        return [
            'RemunerationPackage' => $array,
        ];
    }
}