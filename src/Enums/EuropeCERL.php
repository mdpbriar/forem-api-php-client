<?php

namespace Mdpbriar\ForemApiPhpClient\Enums;

use Mdpbriar\ForemApiPhpClient\Models\Competence;
use Mdpbriar\ForemApiPhpClient\Models\CompetenceNumerique;
use Mdpbriar\ForemApiPhpClient\Models\Dimeco;
use Mdpbriar\ForemApiPhpClient\Models\Langue;
use Mdpbriar\ForemApiPhpClient\Models\NiveauEtude;
use Mdpbriar\ForemApiPhpClient\Models\PermisConduire;
use Mdpbriar\ForemApiPhpClient\Models\RomeV3;

enum EuropeCERL: int
{
    case A1 = 1;
    case A2 = 2;
    case B1 = 3;
    case B2 = 4;
    case C1 = 5;
    case C2 = 6;

    public function getLabel(): string
    {
        return match ($this) {
            self::A1 => "A1",
            self::A2 => "A2",
            self::B1 => "B1",
            self::B2 => "B2",
            self::C1 => "C1",
            self::C2 => "C2",

        };
    }
}
