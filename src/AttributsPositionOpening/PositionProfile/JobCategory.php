<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile;

use Mdpbriar\ForemApiPhpClient\Enums\TaxonomyName;

class JobCategory
{

    public TaxonomyName $taxonomyName;
    protected string $taxonomyVersion;
    protected string $categoryCode;
    protected string $categoryDescription;

    public function __construct(
        string $taxonomyName,
        string $categoryCode,
        ?string $categoryDescription = null,
    )
    {
        $this->setTaxonomyName($taxonomyName);
        $this->setCategoryCode($categoryCode);
        $this->setCategoryDescription($categoryDescription);

    }

    private function setTaxonomyName(string $taxonomyName): void
    {
        try {
            $this->taxonomyName = TaxonomyName::from($taxonomyName);
            $model = $this->taxonomyName->getModel();
            $this->taxonomyVersion = $model::getVersion();

        } catch (\Exception $exception){
            throw new \UnexpectedValueException("Taxonomy name n'utilise pas une valeur valide");
        }
    }

    private function setCategoryCode(string $categoryCode): void
    {
        $model = $this->taxonomyName->getModel();
        if (!$model::isValidId($categoryCode)){
            throw new \UnexpectedValueException("Le code choisi ne se trouve pas dans la nomenclature {$this->taxonomyName->value}");
        }
        $this->categoryCode = $categoryCode;
    }

    private function setCategoryDescription(?string $categoryDescription): void
    {
        if (!$categoryDescription){
            $model = $this->taxonomyName->getModel();
            $categoryDescription = $model::getFromId($this->categoryCode)?->description;
        }
        $this->categoryDescription = $categoryDescription;
    }

    public function getArray(): array
    {
        return [
            'TaxonomyName' => [
                '_attributes'=> [
                    'version' => $this->taxonomyVersion,
                ],
                '_value' => $this->taxonomyName->value,
            ],
            'CategoryCode' => $this->categoryCode,
            'CategoryDescription' => $this->categoryDescription,
        ];
    }

}