<?php

use PHPUnit\Framework\TestCase;

final class UserAreaTest extends TestCase
{
    public function testExperienceCreation(): void
    {

        $tests = [
            [
                'userArea' => [
                    'experience' => 2,
                    'unitOfMeasure' => 'Years',
                ],
                'expected' => "<root><UserArea><Experience unitOfMeasure=\"Years\">2</Experience></UserArea></root>"
            ],
            [
                'userArea' => [
                    'experience' => 48,
                    'unitOfMeasure' => 'Months',
                ],
                'expected' => "<root><UserArea><Experience unitOfMeasure=\"Months\">48</Experience></UserArea></root>"
            ],

        ];

        foreach ($tests as $test){
            $userArea = new \Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\UserArea(
                experience: $test['userArea']['experience'],
                unitOfMeasure: $test['userArea']['unitOfMeasure'],
            );
            $expected = $test['expected'];
            $xml = new \Spatie\ArrayToXml\ArrayToXml($userArea->getArray());
            \PHPUnit\Framework\assertSame($expected, $xml->dropXmlDeclaration()->toXml());

        }

    }


    public function testThrowErrorWrongUnit(): void
    {

        $this->expectException(ValueError::class);
        $experience = [
            'experience' => 5,
            'unitOfMeasure' => 'Days',
        ];
        $userArea = new \Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail\UserArea(
            experience: $experience['experience'],
            unitOfMeasure: $experience['unitOfMeasure'],
        );



    }
}