<?php

namespace PositionProfile\PositionDetail\Competency;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\DeliveryAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\Telephone;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescription\FormattedPositionDescription;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescriptions;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency\CompetencyEvidence;
use PHPUnit\Framework\TestCase;

final class CompetencyEvidenceTest extends TestCase
{
    public function testCreation(): void
    {

        $tests = [
            [
                'options' => [
                    'value' => 5,
                    'minValue' => 1
                ],
                'expected' => '<root><CompetencyEvidence minValue="1">5</CompetencyEvidence></root>'
            ],
            [
                'options' => [
                    'value' => 4,
                    'language' => true
                ],
                'expected' => '<root><CompetencyEvidence minValue="1" maxValue="6">4</CompetencyEvidence></root>'
            ],
            [
                'options' => [
                    'value' => 4,
                    'minValue' => 2,
                    'maxValue' => 8,
                    'language' => true
                ],
                'expected' => '<root><CompetencyEvidence minValue="1" maxValue="6">4</CompetencyEvidence></root>'
            ],

        ];

        foreach ($tests as $test){
            $result = new CompetencyEvidence(...$test['options']);
            $expected = $test['expected'];
            $xml = new \Spatie\ArrayToXml\ArrayToXml($result->getArray());
            \PHPUnit\Framework\assertSame($expected, $xml->dropXmlDeclaration()->toXml());

        }

    }


    public function testThrowErrorIfWrongValueWithLanguage(): void
    {

        $this->expectException(\ValueError::class);
        $options = [
            'value' => 9,
            'language' => true
        ];
        $result = new CompetencyEvidence(...$options);

    }



}