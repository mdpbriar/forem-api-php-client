<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\PositionSchedule;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\RemunerationPackage;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Shift;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\UserArea;
use Mdpbriar\ForemApiPhpClient\Models\ContratTravail;
use Mdpbriar\ForemApiPhpClient\Models\Nacebel2008;
use Mdpbriar\ForemApiPhpClient\ValidateOptions;

class PositionDetail
{

    protected string $industryCode;
//    protected PostalAddress $physicalLocation;
    protected array $physicalLocations;

    protected JobCategories $jobCategories;
    protected string $positionTitle;
    protected ContratTravail $positionClassification;
    protected PositionSchedule $positionSchedule;

    protected array $shifts = [];
    protected array $competencies = [];

    protected ?RemunerationPackage $remunerationPackage = null;
    protected ?Travel $travel = null;
    protected ?Relocation $relocation = null;

    protected UserArea $userArea;

    public function __construct(
        array $positionDetail,
    )
    {
        $required_fields = ['industryCode', 'physicalLocation', 'jobCategories', 'positionTitle', 'positionClassification', 'positionSchedule', 'competencies', 'userArea'];
        ValidateOptions::validateArrayFields($positionDetail, $required_fields);

        $this->setIndustryCode($positionDetail['industryCode']);
        $this->physicalLocation = new PostalAddress($positionDetail['physicalLocation']);
        $this->jobCategories = new JobCategories($positionDetail['jobCategories']);
        $this->positionTitle = $positionDetail['positionTitle'];
        $this->setPositionClassification($positionDetail['positionClassification']);
        $this->positionSchedule = new PositionSchedule($positionDetail['positionSchedule']);
        # Si on a des shifts déclarés, on créé les shifts avec la classe correspondante
        if (isset($positionDetail['shifts'])){
            foreach ($positionDetail['shifts'] as $shift){
                $this->shifts[] = new Shift(
                    shiftPeriod: $shift['shiftPeriod'],
                    hours: $shift['hours'] ?? null,
                    startTime: $shift['startTime'] ?? null,
                    endTime: $shift['endTime'] ?? null,
                );
            }
        }

        foreach ($positionDetail['competencies'] as $competency){
            $this->competencies[] = new Competency(
                $competency['name'],
                $competency['id'],
                value: $competency['value'] ?? null,
                minValue: $competency['minValue'] ?? null,
                maxValue: $competency['maxValue'] ?? null
            );
        }
        if ($positionDetail['remunerationPackage']){
            $this->remunerationPackage = new RemunerationPackage($positionDetail['remunerationPackage']);
        }

        $this->userArea = new UserArea(
            experience: $positionDetail['userArea']['experience'],
            unitOfMeasure: $positionDetail['userArea']['unitOfMeasure']
        );

        if (isset($positionDetail['travel'])){
            $this->travel = new Travel($positionDetail['travel']);
        }

        if (isset($positionDetail['relocation'])){
            $this->relocation = new Relocation($positionDetail['relocation']);
        }



    }

    public function setPhysicalLocations(array $physicalLocations): void
    {
        foreach ($physicalLocations as $physicalLocation){
            $this->physicalLocations[] = new PostalAddress($physicalLocation);
        }

    }

    public function setIndustryCode($industryCode): void
    {
        if (Nacebel2008::isValidId($industryCode)){
            $this->industryCode = $industryCode;
        } else {
            throw new \UnexpectedValueException("{$industryCode} n'est pas un code NaceBel2008 valide");
        }
    }

    public function setPositionClassification(string $positionClassification): void
    {
        $this->positionClassification = ContratTravail::getFromId($positionClassification);
    }

    private function getShiftsArray(): ?array
    {
        if (!$this->shifts){
            return null;
        }
        return array_map(function(Shift $shift){
            return $shift->getArray();
        }, $this->shifts);
    }

    private function getPhysicalLocationsArray(): array
    {
        return array_map(function(PostalAddress $physicalLocation){
            return $physicalLocation->getArray();
        }, $this->physicalLocations);
    }

    private function getCompetenciesArray(): array
    {
        return array_map(function(Competency $competency){
            return $competency->getArray();
        }, $this->competencies);
    }

    public function getArray(): array
    {
        $array = $this->getPhysicalLocationsArray();
        $array = array_merge($array, ...$this->jobCategories->getArray());
        $array['PositionTitle'] = $this->positionTitle;
        $array['PositionClassification'] = $this->positionClassification->id;
        $array = array_merge($array, ...$this->positionSchedule->getArray());

        if ($this->shifts){
            $array = array_merge($array, ...$this->getShiftsArray());
        }
        $array = array_merge($array, ...$this->getCompetenciesArray());

        // Si remuneration Package est défini :
        if ($this->remunerationPackage){
            $array = array_merge($array, $this->remunerationPackage->getRemunerationPackageArray());
        }
        $array = array_merge($array, $this->userArea->getUserAreaArray());

        return [
            'PositionDetail' => [
                'IndustryCode' => [
                    '_attributes' => [
                        'classificationName' => 'NaceBel2008'
                    ],
                    '_value' => $this->industryCode,
                ],
                ...$this->physicalLocation->getArray(),
                ...$this->jobCategories->getArray(),
                'PositionTitle' => $this->positionTitle,
                'PositionClassification' => $this->positionClassification->id,
                ...$this->positionSchedule->getArray(),
                ...$array
            ],
        ];

        if ($this->shifts){
            $array['PositionDetail'] = array_merge($array['PositionDetail'], ...$this->getShiftsArray());
        }
        $array['PositionDetail'] = array_merge($array['PositionDetail'], ...$this->getCompetenciesArray());

        // Si remuneration Package est défini :
        if ($this->remunerationPackage){
            $array['PositionDetail'] = array_merge($array['PositionDetail'], $this->remunerationPackage->getArray());
        }
        if ($this->travel){
            $array['PositionDetail'] = array_merge($array['PositionDetail'], $this->travel->getArray());
        }
        if ($this->relocation){
            $array['PositionDetail'] = array_merge($array['PositionDetail'], $this->relocation->getArray());
        }

        $array['PositionDetail'] = array_merge($array['PositionDetail'], $this->userArea->getArray());

        return $array;
    }

}