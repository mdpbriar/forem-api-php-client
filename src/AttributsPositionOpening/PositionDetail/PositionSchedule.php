<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionDetail;

use Mdpbriar\ForemApiPhpClient\Models\TempsTravail;

class PositionSchedule
{
    protected TempsTravail $positionRegime;
    protected TempsTravail $positionHoraire;

    public function __construct(
        array $positionSchedule,
    )
    {
        $this->setPositionRegime($positionSchedule['positionRegime']);
        $this->setPositionHoraire($positionSchedule['positionHoraire']);
    }

    private function setPositionRegime(string $positionRegime): void
    {
        $this->positionRegime = TempsTravail::getFromId($positionRegime);
    }

    private function setPositionHoraire(string $positionHoraire): void
    {
        $this->positionHoraire = TempsTravail::getFromId($positionHoraire);
    }

    public function getPositionScheduleArray(): array
    {
        return [
            '__custom:PositionSchedule:regime' => $this->positionRegime->id,
            '__custom:PositionSchedule:horaire' => $this->positionHoraire->id,
        ];
    }



}