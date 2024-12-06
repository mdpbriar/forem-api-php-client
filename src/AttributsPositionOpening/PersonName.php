<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Carbon\Carbon;
use Mdpbriar\ForemApiPhpClient\Enums\PositionRecordStatus;

class PersonName
{

    public ?string $preferredGivenName = null;
    public ?string $familyName = null;
    public ?string $formattedName = null;
    public ?string $affix = null;


    public function __construct(
        array $personName
    ){
        $this->preferredGivenName = $personName['preferredGivenName'] ?? null;
        $this->familyName = $personName['familyName'] ?? null;
        $this->formattedName = $personName['formattedName'] ?? null;
        $this->affix = $personName['affix'] ?? null;

    }

    public function getArray(): ?array
    {
        $array = [];
        if ($this->formattedName){
            $array['FormattedName'] = $this->formattedName;
        }
        if ($this->preferredGivenName){
            $array['PreferredGivenName'] = $this->preferredGivenName;
        }
        if ($this->familyName){
            $array['FamilyName'] = $this->familyName;
        }
        if ($this->affix){
            $array['Affix'] = $this->affix;
        }


        return [
            'PersonName' => $array
        ];
    }

}