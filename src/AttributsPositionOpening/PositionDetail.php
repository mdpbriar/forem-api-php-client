<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionDetail\PositionSchedule;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionDetail\Shift;
use Mdpbriar\ForemApiPhpClient\Models\ContratTravail;
use Mdpbriar\ForemApiPhpClient\Models\Nacebel2008;

class PositionDetail
{

    protected string $industryCode;
    protected PostalAddress $physicalLocation;

    protected JobCategories $jobCategories;
    protected string $positionTitle;
    protected ContratTravail $positionClassification;
    protected PositionSchedule $positionSchedule;

    protected array $shifts = [];


    public function __construct(
        string $industryCode,
        array $physicalLocation,
        array $jobCategories,
        string $positionTitle,
        string $positionClassification,
        array $positionSchedule,
        array $shifts = null,
    )
    {
        $this->setIndustryCode($industryCode);
        $this->physicalLocation = new PostalAddress(
            countryCode: $physicalLocation['countryCode'],
            postalCode: $physicalLocation['postalCode'],
            municipality: $physicalLocation['municipality'] ?? null,
        );
        $this->jobCategories = new JobCategories($jobCategories);
        $this->positionTitle = $positionTitle;
        $this->setPositionClassification($positionClassification);
        $this->positionSchedule = new PositionSchedule($positionSchedule);
        # Si on a des shifts déclarés, on créé les shifts avec la classe correspondante
        if ($shifts){
            foreach ($shifts as $shift){
                $shiftObj = new Shift(
                    shiftPeriod: $shift['shiftPeriod'],
                    hours: $shift['hours'] ?? null,
                    startTime: $shift['startTime'] ?? null,
                    endTime: $shift['endTime'] ?? null,
                );
                $this->shifts[] = $shiftObj;
            }
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
            return $shift->getShiftArray();
        }, $this->shifts);
    }

    public function getPositionDetailArray(): array
    {
        $array = [
            'PositionDetail' => [
                'IndustryCode' => [
                    '_attributes' => [
                        'classificationName' => 'NaceBel2008'
                    ],
                    '_value' => $this->industryCode,
                ],
            ...$this->physicalLocation->getPostalAddressArray(),
            ...$this->jobCategories->getJobCategoriesArray(),
                'PositionTitle' => $this->positionTitle,
                'PositionClassification' => $this->positionClassification->id,
                ...$this->positionSchedule->getPositionScheduleArray(),
            ],
        ];

        if ($this->shifts){
            $array['PositionDetail'] = array_merge($array['PositionDetail'], ...$this->getShiftsArray());
        }

        return $array;
    }

}