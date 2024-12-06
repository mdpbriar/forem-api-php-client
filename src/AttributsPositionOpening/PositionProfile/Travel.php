<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile;

class Travel
{

    protected ?bool $applicable = null;
    protected ?string $travelConsiderations = null;
    protected ?string $travelFrequency = null;
    public function __construct(
        array $travel
    )
    {
        $this->setOptions($travel);
    }

    private function setOptions(array $options): void
    {
        $this->applicable = $options['applicable'] ?? null;
        $this->travelConsiderations = $options['travelConsiderations'] ?? null;
        $this->travelFrequency = $options['travelFrequency'] ?? null;
    }

    public function getArray(): array
    {
        $array = [];
        if ($this->applicable !== null){
            $array['Applicable'] = $this->applicable ? 'true':'false';
        }
        if ($this->travelConsiderations){
            $array['TravelConsiderations'] = $this->travelConsiderations;
        }
        if ($this->travelFrequency){
            $array['TravelFrequency'] = $this->travelFrequency;
        }

        return [
            'Travel' => $array
        ];
    }
}