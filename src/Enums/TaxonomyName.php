<?php

namespace Mdpbriar\ForemApiPhpClient\Enums;

use Mdpbriar\ForemApiPhpClient\Models\BaseModel;
use Mdpbriar\ForemApiPhpClient\Models\Dimeco;
use Mdpbriar\ForemApiPhpClient\Models\RomeV3;

enum TaxonomyName: string
{
    case ROMEV3 = "ROMEV3";
    case DIMECO = "DIMECO";

    public function getModel(): string
    {
        return match ($this) {
            self::ROMEV3 => RomeV3::class,
            self::DIMECO => Dimeco::class,
        };
    }
}
