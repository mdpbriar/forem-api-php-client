<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency\CompetencyEvidence;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency\CompetencyId;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency\TaxonomyId;
use Mdpbriar\ForemApiPhpClient\Enums\CompetencyType;

class Competency
{
    public CompetencyType $name;
    public CompetencyId $competencyId;
    public TaxonomyId $taxonomyId;

    public ?CompetencyEvidence $competencyEvidence = null;

    /**
     * @throws \Exception
     */
    public function __construct(
        string $name,
        string|int $id,
        ?int $value = null,
        ?int $minValue = null,
        ?int $maxValue = null,
    )
    {
        $this->setName($name);
        $this->competencyId = new CompetencyId($this->name, $id);
        $this->taxonomyId = new TaxonomyId($this->name, $id);
        $this->setCompetencyEvidence($value, $minValue, $maxValue);

    }

    private function setName($name){
        try {
            $this->name = CompetencyType::from($name);
        } catch (\Exception $exception){
            throw new \UnexpectedValueException("{$name} n'est pas un type de compétence valide");
        }
    }

    /**
     * @throws \Exception
     */
    private function setCompetencyEvidence(?int $value = null, ?int $minValue = null, ?int $maxValue = null): void
    {
        if (in_array($this->name, CompetencyType::MANDATORY_EVIDENCE)){
            if (!$value){
                throw new \UnexpectedValueException("Competency evidence est obligatoire pour {$this->name->value}");
            }
            $this->competencyEvidence = new CompetencyEvidence(
                value: $value,
                minValue: $minValue ?? null,
                maxValue: $maxValue ?? null,
                language: $this->name === CompetencyType::L,
            );
        }
    }

    public function getCompetencyArray(): array
    {
        $array = [
            '_attributes' => [
                'name' => $this->name->value,
            ],
            ...$this->competencyId->getCompetencyIdArray(),
            ...$this->taxonomyId->getTaxonomyIdArray(),
        ];

        if ($this->competencyEvidence){
            $array = array_merge($array, $this->competencyEvidence->getCompetencyEvidenceArray());
        }


        return [
            "__custom:Competency:{$this->competencyId->id}" => $array
        ];
    }

}