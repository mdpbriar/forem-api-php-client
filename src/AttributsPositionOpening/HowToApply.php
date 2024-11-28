<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Carbon\Carbon;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\HowToApply\ApplicationMethod;
use Mdpbriar\ForemApiPhpClient\Enums\PositionRecordStatus;
use Mdpbriar\ForemApiPhpClient\ValidateOptions;

class HowToApply
{
    protected PersonName $personName;
    protected ApplicationMethod $applicationMethod;

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

    }

    public function getHowToApplyArray(): ?array
    {
        return [
            'HowToApply' => [
                ...$this->personName->getPersonNameArray(),
                ...$this->applicationMethod->getArray(),
            ]
        ];

    }

}