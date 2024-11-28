<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency;

use Mdpbriar\ForemApiPhpClient\Enums\CompetencyType;

class TaxonomyId
{
    public string $id;
    public string $description;

    public function __construct(
        CompetencyType $competencyType,
        string|int|null $id,
    )
    {
        $model = $competencyType->getModel($id);
        $this->id = $model::getFieldId();
        $this->description = $model::getFieldDescription();
    }

    public function getTaxonomyIdArray(): array
    {
        return [
            'TaxonomyId' => [
                '_attributes' => [
                    'id' => $this->id,
                    'description' => $this->description,
                ]
            ]
        ];
    }
}