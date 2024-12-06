<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

class UserArea
{
    public ?int $totalNumberOfJobs = null;

    public function __construct(array $userArea)
    {
        $this->setOptions($userArea);
    }

    private function setOptions(array $options): void
    {
        $this->totalNumberOfJobs = $options['totalNumberOfJobs'] ?? null;
    }

    public function getArray(): array
    {
        $array = [];
        if ($this->totalNumberOfJobs){
            $array['TotalNumberOfJobs'] = $this->totalNumberOfJobs;
        }

        return [
            'UserArea' => $array
        ];

    }
}