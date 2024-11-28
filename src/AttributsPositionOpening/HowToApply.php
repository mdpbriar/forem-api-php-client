<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Carbon\Carbon;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\HowToApply\ApplicationMethod;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\HowToApply\UserArea;
use Mdpbriar\ForemApiPhpClient\Enums\PositionRecordStatus;
use Mdpbriar\ForemApiPhpClient\ValidateOptions;

class HowToApply
{
    protected PersonName $personName;
    protected ApplicationMethod $applicationMethod;
    protected ?UserArea $userArea = null;

    public function __construct(
        array $howToApply
    ){
        $this->setOptions($howToApply);
    }

    public function setOptions(array $howToApply): void
    {
        $required_fields = ['personName', 'applicationMethod'];
        ValidateOptions::validateArrayFields($howToApply, $required_fields);
        $this->personName = new PersonName($howToApply['personName']);
        $this->applicationMethod = new ApplicationMethod($howToApply['applicationMethod']);
        $this->userArea = isset($howToApply['userArea']) ? new UserArea($howToApply['userArea']) : null;

    }

    public function getHowToApplyArray(): ?array
    {
        $array = [
            ...$this->personName->getPersonNameArray(),
            ...$this->applicationMethod->getArray(),
        ];

        if ($this->userArea){
            $array = array_merge($array, $this->userArea->getArray());
        }

        return [
            'HowToApply' => $array
        ];

    }

}