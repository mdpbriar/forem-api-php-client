<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescription\FormattedPositionDescription;

class FormattedPositionDescriptions
{
    protected array $formattedPositionDescriptions;

    public function __construct(
        array $formattedPositionDescriptions
    )
    {
        $this->setFormattedDescriptions($formattedPositionDescriptions);
    }

    private function setFormattedDescriptions(array $formattedDescriptions): void
    {
        $this->formattedPositionDescriptions = array_map(function(array $description){
            return new FormattedPositionDescription($description);
        }, $formattedDescriptions);
    }

    public function getArray(): array
    {

        $array = array_merge(...array_map(function (FormattedPositionDescription $description){
            return $description->getArray();
        }, $this->formattedPositionDescriptions));

        return $array;
    }



}