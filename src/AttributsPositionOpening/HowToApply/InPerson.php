<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\HowToApply;

class InPerson
{
    public ?string $travelDirections = null;
    public ?string $additionalInstructions = null;

    public function __construct(array $inPerson)
    {
        $this->setOptions($inPerson);
    }

    private function setOptions(array $inPerson): void
    {
        $this->travelDirections = $inPerson['travelDirections'] ?? null;
        $this->additionalInstructions = $inPerson['additionalInstructions'] ?? null;
    }

    public function getArray(): array
    {
        $array = [];
        if ($this->travelDirections){
            $array['TravelDirections'] = ['_cdata' => $this->travelDirections];
        }
        if ($this->additionalInstructions){
            $array['AdditionalInstructions'] = $this->additionalInstructions;
        }

        return [
            'InPerson' => $array
        ];

    }

}