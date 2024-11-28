<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\RemunerationPackage;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\RemunerationPackage\Benefits\Insurance;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\RemunerationPackage\Benefits\OtherBenefit;

class Benefits
{
    protected array $insurances = [];
    protected ?bool $companyVehicle = null;

    protected array $otherBenefits = [];
    public function __construct(
        array $benefits
    )
    {
        $this->setOptions($benefits);
    }

    private function setOptions(array $options): void
    {
        if (isset($options['insurances'])){
            foreach ($options['insurances'] as $insurance){
                $this->insurances[] =  new Insurance($insurance);
            }
        }

        $this->companyVehicle = $options['companyVehicle'] ?? null;

        if (isset($options['otherBenefits'])){
            foreach ($options['otherBenefits'] as $otherBenefit){
                $this->otherBenefits[] =  new OtherBenefit($otherBenefit);
            }
        }
    }

    private function getInsurancesArray(): array
    {
        return array_map(function(Insurance $insurance){
            return $insurance->getArray();
        }, $this->insurances);
    }

    private function getOtherBenefitsArray(): array
    {
        return array_map(function(OtherBenefit $benefit){
            return $benefit->getArray();
        }, $this->otherBenefits);
    }



    public function getArray(): array
    {
        $array = [];
        if (count($this->insurances)){
            $array = array_merge($array, ...$this->getInsurancesArray());
        }
        if ($this->companyVehicle !==  null){
            $array['CompanyVehicle'] = ['_attributes' => ['companyOffered' => $this->companyVehicle ? 'true':'false']];
        }
        if (count($this->otherBenefits)){
            $array = array_merge($array, ...$this->getOtherBenefitsArray());
        }
        return [
            'Benefits' => $array
        ];
    }
}