<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile;

class JobCategories
{

    protected array $categories;

    public function __construct(
        array $categories,
    )
    {
        if (count($categories) > 2) {
            throw new \UnexpectedValueException("Il ne peut pas y avoir plus de deux catégories pour une offre");
        }
        $jobCategories = [];
        foreach ($categories as $category){
            $jobCategory = new JobCategory(
                taxonomyName: $category['taxonomyName'],
                categoryCode: $category['categoryCode'],
                categoryDescription: $category['categoryDescription'] ?? null,
            );
            if (count($jobCategories) > 0){
                $prevCategory = $jobCategories[0];
                if ($prevCategory->taxonomyName === $jobCategory->taxonomyName){
                    throw new \UnexpectedValueException("Les deux catégories ne peuvent pas avoir le même taxonomyName");
                }
            }
            $jobCategories[] = $jobCategory;
        }
        $this->categories = $jobCategories;

    }

    public function validateCategory(array $category): void
    {
        if (!isset($category['taxonomyName']) || isset($category['categoryCode'])){
            throw new \UnexpectedValueException("Une catégorie d'offre doit avoir les champs 'taxonomyName' et 'categoryCode'");
        }
    }

    public function getJobCategoriesArray(): array
    {
        $categories = [];
        foreach ($this->categories as $category){
            // On utilise la technique __custom de spatie xml pour éviter un duplicate keys dans l'array
            $categories['__custom:JobCategory:'.$category->taxonomyName->value] = $category->getJobCategoryArray();
        }
        return $categories;
    }
}