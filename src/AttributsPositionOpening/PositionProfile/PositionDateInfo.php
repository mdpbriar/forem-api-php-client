<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile;

use Carbon\Carbon;

class PositionDateInfo
{

    public function __construct(
        protected Carbon|string|null $startDate = null,
        protected Carbon|string|null $expectedEndDate = null,
        protected ?bool $asSoonAsPossible = null,
    ){
        $this->setDates($this->startDate, $this->expectedEndDate);
    }

    public function setDates(Carbon|string|null $startDate, Carbon|string|null $expectedEndDate): void
    {
        if ($startDate){
            if (is_string($startDate)){
                $startDate = Carbon::parse($startDate);
            }
            $this->startDate = $startDate->format('Y-m-d');
        }
        if ($expectedEndDate){
            if (is_string($expectedEndDate)){
                $expectedEndDate = Carbon::parse($expectedEndDate);
            }
            $this->expectedEndDate = $expectedEndDate->format('Y-m-d');
        }
    }

    public function getArray(): ?array
    {
        $contents = [];
        if ($this->startDate){
            $contents['StartDate'] = $this->startDate;
        }
        if ($this->expectedEndDate){
            $contents['ExpectedEndDate'] = $this->expectedEndDate;
        }
        if ($this->asSoonAsPossible !== null){
            $contents['AsSoonAsPossible']= $this->asSoonAsPossible ? 'true' : 'false';
        }

        return [
            'PositionDateInfo' => $contents,
        ];
    }

}