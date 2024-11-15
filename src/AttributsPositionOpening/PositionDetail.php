<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use Mdpbriar\ForemApiPhpClient\Models\Nacebel2008;

class PositionDetail
{

    protected string $industryCode;
    protected PostalAddress $physicalLocation;

    protected JobCategories $jobCategories;

    public function __construct(
        string $industryCode,
        array $physicalLocation,
        array $jobCategories,
    )
    {
        $this->setIndustryCode($industryCode);
        $this->physicalLocation = new PostalAddress(
            countryCode: $physicalLocation['countryCode'],
            postalCode: $physicalLocation['postalCode'],
            municipality: $physicalLocation['municipality'] ?? null,
        );
        $this->jobCategories = new JobCategories($jobCategories);

    }

    public function setIndustryCode($industryCode): void
    {
        if (Nacebel2008::isValidId($industryCode)){
            $this->industryCode = $industryCode;
        } else {
            throw new \UnexpectedValueException("{$industryCode} n'est pas un code NaceBel2008 valide");
        }
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
            ],
        ];

        return $array;
    }

}