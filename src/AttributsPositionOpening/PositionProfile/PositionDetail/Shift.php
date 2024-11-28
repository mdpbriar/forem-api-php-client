<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail;

use Mdpbriar\ForemApiPhpClient\Enums\ShiftPeriod;

class Shift
{
    protected ShiftPeriod $shiftPeriod;
    protected ?int $hours = null;
    protected ?string $startTime = null;
    protected ?string $endTime = null;

    public function __construct(
        string $shiftPeriod,
        ?int $hours = null,
        ?string $startTime = null,
        ?string $endTime = null,
    )
    {
        $this->setShiftPeriod($shiftPeriod);
        $this->hours = $hours;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    private function setShiftPeriod(string $shiftPeriod): void
    {
        $this->shiftPeriod = ShiftPeriod::from($shiftPeriod);
    }

    public function getShiftArray(): array
    {
        $array = [
            '_attributes' => [
                'shiftPeriod' => $this->shiftPeriod->value
            ],
        ];
        if ($this->hours){
            $array['Hours'] = $this->hours;
        }
        if ($this->startTime){
            $array['StartTime'] = $this->startTime;
        }
        if ($this->endTime){
            $array['EndTime'] = $this->endTime;
        }
        return [
            "__custom:Shift:{$this->shiftPeriod->name}" => $array
        ];
    }


}