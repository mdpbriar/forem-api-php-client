<?php

namespace PositionProfile;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\DeliveryAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\Telephone;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescription\FormattedPositionDescription;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescriptions;
use PHPUnit\Framework\TestCase;

final class FormattedPositionDescriptionTest extends TestCase
{
    public function testCreation(): void
    {

        $tests = [
            [
                'options' => [
                    'name' => "jobDescription",
                    'value' => "super job"
                ],
                'expected' => "<root><FormattedPositionDescription><Name>jobDescription</Name><Value><![CDATA[super job]]></Value></FormattedPositionDescription></root>"
            ],
            [
                'options' => [
                    'name' => "contractInformation",
                    'value' => "information"
                ],
                'expected' => "<root><FormattedPositionDescription><Name>contractInformation</Name><Value><![CDATA[information]]></Value></FormattedPositionDescription></root>"
            ],
            [
                'options' => [
                    'name' => "companyPromotionalText",
                    'value' => "super boite"
                ],
                'expected' => "<root><FormattedPositionDescription><Name>companyPromotionalText</Name><Value><![CDATA[super boite]]></Value></FormattedPositionDescription></root>"
            ],

        ];

        foreach ($tests as $test){
            $result = new FormattedPositionDescription($test['options']);
            $expected = $test['expected'];
            $xml = new \Spatie\ArrayToXml\ArrayToXml($result->getArray());
            \PHPUnit\Framework\assertSame($expected, $xml->dropXmlDeclaration()->toXml());

        }

    }


    public function testThrowErrorIfWrongName(): void
    {

        $this->expectException(\UnexpectedValueException::class);
        $options = [
            'name' => 'wrongText',
            'value' => "test"
        ];
        $result = new FormattedPositionDescription($options);

    }

    public function testFormattedPositionDescriptions(): void
    {
        $tests = [
            [
                'options' =>[
                    [
                        'name' => "jobDescription",
                        'value' => "super job"
                    ],
                    [
                        'name' => "contractInformation",
                        'value' => "information"
                    ],
                    [
                        'name' => "companyPromotionalText",
                        'value' => "super boite"
                    ],
                ],
                'expected' => "<root><FormattedPositionDescription><Name>jobDescription</Name><Value><![CDATA[super job]]></Value></FormattedPositionDescription><FormattedPositionDescription><Name>contractInformation</Name><Value><![CDATA[information]]></Value></FormattedPositionDescription><FormattedPositionDescription><Name>companyPromotionalText</Name><Value><![CDATA[super boite]]></Value></FormattedPositionDescription></root>"

            ]
        ];

        foreach ($tests as $test){
            $result = new FormattedPositionDescriptions($test['options']);
            $expected = $test['expected'];
            $xml = new \Spatie\ArrayToXml\ArrayToXml($result->getArray());
            \PHPUnit\Framework\assertSame($expected, $xml->dropXmlDeclaration()->toXml());

        }

    }




}