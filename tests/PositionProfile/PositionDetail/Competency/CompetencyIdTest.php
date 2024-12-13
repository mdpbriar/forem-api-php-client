<?php

namespace PositionProfile\PositionDetail\Competency;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\DeliveryAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\Telephone;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescription\FormattedPositionDescription;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescriptions;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency\CompetencyEvidence;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency\CompetencyId;
use Mdpbriar\ForemApiPhpClient\Enums\CompetencyType;
use PHPUnit\Framework\TestCase;

final class CompetencyIdTest extends TestCase
{
    public function testCreation(): void
    {

        $tests = [
            [
                'options' => [
                    'competencyName' => CompetencyType::DL,
                    'competencyId' => 'A2'
                ],
                'expected' => '<root><CompetencyId id="A2" description="Moto &lt; 35 kW"/></root>'
            ],
            [
                'options' => [
                    'competencyName' => CompetencyType::L,
                    'competencyId' => 'bn'
                ],
                'expected' => '<root><CompetencyId id="bn" description="Bengali"/></root>'
            ],

        ];

        foreach ($tests as $test){
            $result = new CompetencyId(...$test['options']);
            $expected = $test['expected'];
            $xml = new \Spatie\ArrayToXml\ArrayToXml($result->getArray());
            $xml->setDomProperties(['encoding' => 'UTF-8']);
            \PHPUnit\Framework\assertSame($expected, $xml->dropXmlDeclaration()->toXml());

        }

    }


    public function testThrowErrorIfWrongId(): void
    {

        $this->expectException(\Throwable::class);
        $options = [
            'competencyName' => CompetencyType::OS,
            'competencyId' => 'testfail'
        ];
        $result = new CompetencyId(...$options);

    }



}