<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionDetail\Competency;

use Mdpbriar\ForemApiPhpClient\Enums\CompetencyType;

class CompetencyId
{
    public string $id;
    public ?string $description = null;

    public function __construct(
        CompetencyType $competencyName,
        int|string $competencyId,
    )
    {
        $this->setCompetencyId($competencyName, $competencyId);
    }

    private function setCompetencyId(CompetencyType $competencyType, int|string $competencyId): void
    {
        $model = $competencyType->getModel($competencyId);
        $competence = $model::getFromId($competencyId);
        $this->id = $competence->id;
        $this->description = $competence->description;
    }

    public function getCompetencyIdArray(): array
    {
        return [
            'CompetencyId' => [
                '_attributes' => [
                    'id' => $this->id,
                    'description' => $this->description,
                ]
            ]
        ];
    }
}