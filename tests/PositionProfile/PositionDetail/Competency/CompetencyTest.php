<?php

namespace PositionProfile\PositionDetail\Competency;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\DeliveryAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\Telephone;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescription\FormattedPositionDescription;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescriptions;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency\CompetencyEvidence;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency\CompetencyId;
use Mdpbriar\ForemApiPhpClient\Enums\CompetencyType;
use PHPUnit\Framework\TestCase;

final class CompetencyTest extends TestCase
{
    public function testCreation(): void
    {

        $tests = [
            [
                'options' => [
                    'name' => 'Language',
                    'id' => 'bn',
                    'value' => 5,
                ],
                'expected' => '<root><Competency name="Language"><CompetencyId id="bn" description="Bengali"/><TaxonomyId id="ISO 639-1" description="ISO 639-1 norme internationale de codification des noms de langues en 2 chiffres"/><CompetencyEvidence minValue="1" maxValue="6">5</CompetencyEvidence></Competency></root>'
            ],
            [
                'options' => [
                    'name' => 'Office Skills',
                    'id' => '30',
                ],
                'expected' => '<root><Competency name="Office Skills"><CompetencyId id="30" description="Création de contenu"/><TaxonomyId id="ESCO" description="Aptitudes ESCO"/></Competency></root>'
            ],
        ];

        foreach ($tests as $test){
            $result = new Competency(...$test['options']);
            $expected = $test['expected'];
            $xml = new \Spatie\ArrayToXml\ArrayToXml($result->getArray());
            $xml->setDomProperties(['encoding' => 'UTF-8']);
            \PHPUnit\Framework\assertSame($expected, $xml->dropXmlDeclaration()->toXml());

        }

    }


    public function testThrowErrorIfWrongId(): void
    {

        $this->expectException(\UnexpectedValueException::class);
        $options = [
            'name' => 'Language',
            'id' => 'bn',
        ];
        $result = new Competency(...$options);

    }



}