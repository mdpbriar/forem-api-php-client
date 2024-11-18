<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionDetail\PositionSchedule;
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


    public function __construct(
        string $industryCode,
        array $physicalLocation,
        array $jobCategories,
        string $positionTitle,
        string $positionClassification,
        array $positionSchedule,
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

        return $array;
    }

}