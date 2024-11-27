<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Carbon\Carbon;
use Mdpbriar\ForemApiPhpClient\Enums\PositionRecordStatus;

class HowToApply
{
    public PersonName $personName;
    public function __construct(
        array $howToApply
    ){

        $this->personName = new PersonName($howToApply['personName']);

    }

    public function getHowToApplyArray(): ?array
    {
        return [
            'HowToApply' => [
                ...$this->personName->getPersonNameArray()
            ]
        ];

    }

}