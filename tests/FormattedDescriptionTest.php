<?php

use PHPUnit\Framework\TestCase;

final class FormattedDescriptionTest extends TestCase
{
    public function testFormattedDescriptionCreation(): void
    {
        $faker = Faker\Factory::create();
        $jobDescription = $faker->paragraph();

        $tests = [
            [
                'formattedDescription' => [
                    'name' => 'jobDescription',
                    'value' => $jobDescription,
                ],
                'expected' => "<root><FormattedPositionDescription><Name>jobDescription</Name><Value><![CDATA[$jobDescription]]></Value></FormattedPositionDescription></root>"
            ],

        ];

        foreach ($tests as $test){
            $formattedDescription = new \Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescription\FormattedPositionDescription(
                formattedDescription: $test['formattedDescription'],
            );
            $expected = $test['expected'];
            $xml = new \Spatie\ArrayToXml\ArrayToXml($formattedDescription->getArray());
            \PHPUnit\Framework\assertSame($expected, $xml->dropXmlDeclaration()->toXml());

        }

    }


    public function testThrowErrorWrongUnit(): void
    {

        $this->expectException(UnexpectedValueException::class);
        $test = [
            'name' => 'unTestQuiNePassePas',
            'value' => 'Voilà quoi',
        ];
        $userArea = new \Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescription\FormattedPositionDescription(
            $test
        );



    }
}