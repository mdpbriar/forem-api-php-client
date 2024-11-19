<?php

namespace Mdpbriar\ForemApiPhpClient\Enums;

use Mdpbriar\ForemApiPhpClient\Models\Competence;
use Mdpbriar\ForemApiPhpClient\Models\CompetenceNumerique;
use Mdpbriar\ForemApiPhpClient\Models\Dimeco;
use Mdpbriar\ForemApiPhpClient\Models\Langue;
use Mdpbriar\ForemApiPhpClient\Models\NiveauEtude;
use Mdpbriar\ForemApiPhpClient\Models\PermisConduire;
use Mdpbriar\ForemApiPhpClient\Models\RomeV3;

enum CompetencyType: string
{
    case SC = "Study Code";
    case DL = "Drivers License";
    case L = "Language";
    case C = "Competency";
    case PE = "Proven Experience";
    case OS = "Office Skills";

    const MANDATORY_EVIDENCE = [self::L, self::PE];

    public function getModel(string|int|null $id = null): string
    {
        return match ($this) {
            self::SC => NiveauEtude::class,
            self::DL => PermisConduire::class,
            self::L => Langue::class,
            self::C => Competence::class,
            self::PE => $id && Dimeco::isValidId($id) ? Dimeco::class : RomeV3::class,
            self::OS => CompetenceNumerique::class,
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::SC => "Niveau d'étude",
            self::DL => "Permis de conduire",
            self::L => "Compétences linguistiques",
            self::C => "Compétences",
            self::PE => "Expérience",
            self::OS => "Compétences numériques",
        };
    }


}
