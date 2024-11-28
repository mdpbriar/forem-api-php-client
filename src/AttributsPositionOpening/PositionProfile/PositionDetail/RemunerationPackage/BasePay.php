<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\RemunerationPackage;

use Mdpbriar\ForemApiPhpClient\Enums\BasePayInterval;

class BasePay
{
    public string $currencyCode = "EUR";
    public BasePayInterval $baseInterval = BasePayInterval::Monthly;

    public float $basePayAmountMin;

    public float $basePayAmountMax;

    public function __construct(
        float $basePayAmountMin,
        float $basePayAmountMax,
        ?string $currencyCode = null,
        ?string $baseInterval = null,
    )
    {
        $this->basePayAmountMin = $basePayAmountMin;
        $this->basePayAmountMax = $basePayAmountMax;
        $this->setCurrencyCode($currencyCode);
        $this->setBaseInterval($baseInterval);
    }

    private function setCurrencyCode(?string $currencyCode = null): void
    {
        if ($currencyCode){
            $this->currencyCode = $currencyCode;
        }
    }

    private function setBaseInterval(?string $baseInterval = null): void
    {
        if ($baseInterval){
            $this->baseInterval = BasePayInterval::from($baseInterval);
        }
    }

    public function getArray(): array
    {
        return [
            'BasePay' => [
                '_attributes' => [
                    'baseInterval' => $this->baseInterval->value,
                    'currencyCode' => $this->currencyCode
                ],
                'BasePayAmountMin' => $this->basePayAmountMin,
                'BasePayAmountMax' => $this->basePayAmountMax,
            ]
        ];
    }

}