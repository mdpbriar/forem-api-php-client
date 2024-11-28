<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Carbon\Carbon;
use Mdpbriar\ForemApiPhpClient\Enums\PositionRecordStatus;

class StatusPosition
{

    public function __construct(
        protected Carbon|string|null $validFrom,
        protected Carbon|string|null $validTo,
        protected PositionRecordStatus|string|null $statut = PositionRecordStatus::Active
    ){
        if ($validTo && $validFrom){
            $this->setStatus($validFrom, $validTo, $statut);
        }
    }

    public function setStatus(Carbon|string|null $validFrom, Carbon|string|null $validTo, PositionRecordStatus|string|null $statut = null): void
    {
        if (!$statut){
            $statut = PositionRecordStatus::Active;
        }
        if (is_string($statut)){
            $statut = PositionRecordStatus::from($statut);
        }
        if (is_string($validFrom)){
            $validFrom = Carbon::parse($validFrom);
        }
        if (is_string($validTo)){
            $validTo = Carbon::parse($validTo);
        }

        $this->statut = $statut;
        $this->validFrom = $validFrom->format('Y-m-d');
        $this->validTo = $validTo->format('Y-m-d');
    }

    public function getArray(): ?array
    {
        $attributes = [];
        if ($this->validTo && $this->validFrom){
            $attributes = [
                'validFrom' => $this->validFrom,
                'validTo' => $this->validTo,
            ];
        }
        return [
            'Status' => [
                '_attributes' => $attributes,
                '_value' => $this->statut->value,
            ],
        ];
    }

}