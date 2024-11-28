<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail;

use Mdpbriar\ForemApiPhpClient\Enums\ExperienceUnitOfMeasure;

class UserArea
{
    public ExperienceUnitOfMeasure $unitOfMeasure = ExperienceUnitOfMeasure::Years;
    public int $experience;

    public function __construct(
        int $experience,
        ?string $unitOfMeasure = null,
    )
    {
        $this->experience = $experience;
        if ($unitOfMeasure){
            $this->unitOfMeasure = ExperienceUnitOfMeasure::from($unitOfMeasure);
        }
    }

    public function getUserAreaArray(): array
    {
        return [
            'UserArea' => [
                'Experience' => [
                    '_attributes' => [
                        'unitOfMeasure' => $this->unitOfMeasure->value
                    ],
                    '_value' => (string)$this->experience,
                ]
            ]
        ];
    }
}