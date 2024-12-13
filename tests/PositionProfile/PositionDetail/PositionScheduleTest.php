<?php

namespace PositionProfile\PositionDetail;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\Competency\CompetencyId;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\PositionSchedule;
use Mdpbriar\ForemApiPhpClient\Enums\CompetencyType;
use PHPUnit\Framework\TestCase;

final class PositionScheduleTest extends TestCase
{
    public function testCreation(): void
    {

        $tests = [
            [
                'options' => [
                    'positionRegime' => "Full Time",
                    'positionHoraire' => 'x:Day Work'
                ],
                'expected' => '<root><PositionSchedule>Full Time</PositionSchedule><PositionSchedule>x:Day Work</PositionSchedule></root>'
            ],

            [
                'options' => [
                    'positionRegime' => "Full Time",
                    'positionHoraire' => 'x:3 Shift System'
                ],
                'expected' => '<root><PositionSchedule>Full Time</PositionSchedule><PositionSchedule>x:3 Shift System</PositionSchedule></root>'
            ],

        ];

        foreach ($tests as $test){
            $result = new PositionSchedule($test['options']);
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
            'positionRegime' => "Full Time",
            'positionHoraire' => 'x:Day Blabla'
        ];
        $result = new PositionSchedule($options);

    }



}