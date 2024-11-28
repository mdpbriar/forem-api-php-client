<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency;

use Mdpbriar\ForemApiPhpClient\Enums\EuropeCERL;

class CompetencyEvidence
{

    const LANG_MIN_VALUE = 1;
    const LANG_MAX_VALUE = 6;


    public int $value;
    public ?int $minValue = null;
    public ?int $maxValue = null;

    public function __construct(
        int $value,
        ?int $minValue = null,
        ?int $maxValue = null,
        bool $language = false,
    )
    {
        if ($language){
            $this->setAsLang($value);
        } else {
            $this->value = $value;
            $this->minValue = $minValue;
            $this->maxValue = $maxValue;
        }

    }

    private function setAsLang(int $value){
        try {
            $niveau = EuropeCERL::from($value);
            $this->value = $niveau->value;
            $this->minValue = self::LANG_MIN_VALUE;
            $this->maxValue = self::LANG_MAX_VALUE;
        } catch (\Exception $e){
            throw new \UnexpectedValueException("Pour une langue, la valeur dans competency evidence doit être entre ".self::LANG_MIN_VALUE." et ".self::LANG_MAX_VALUE);
        }
    }


    public function getArray(): array
    {

        $attributes = [];
        if ($this->minValue){
            $attributes['minValue'] = $this->minValue;
        }
        if ($this->maxValue){
            $attributes['maxValue'] = $this->maxValue;
        }

        return [
            'CompetencyEvidence' => [
                '_attributes' => $attributes,
                '_value' => (string)$this->value,
            ]
        ];
    }

}