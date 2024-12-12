<?php

namespace ContactMethod;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\DeliveryAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\Telephone;
use PHPUnit\Framework\TestCase;

final class TelephoneTest extends TestCase
{
    public function testCreation(): void
    {

        $tests = [
            [
                'options' => [
                    'subscriberNumber' => "0123456789",
                ],
                'expected' => "<root><Telephone><SubscriberNumber>0123456789</SubscriberNumber></Telephone></root>"
            ],
            [
                'options' => [
                    'subscriberNumber' => "0123456789",
                    'internationalCountryCode' => '0032',
                    'formattedNumber' => "+32 123 456 789"
                ],
                'expected' => "<root><Telephone><SubscriberNumber>0123456789</SubscriberNumber><InternationalCountryCode>0032</InternationalCountryCode><FormattedNumber>+32 123 456 789</FormattedNumber></Telephone></root>"
            ],
            [
                'options' => [ # check if internationalCountryCode is deleted
                    'subscriberNumber' => "0123456789",
                    'internationalCountryCode' => '+32',
                    'formattedNumber' => "+32 123 456 789"
                ],
                'expected' => "<root><Telephone><SubscriberNumber>0123456789</SubscriberNumber><FormattedNumber>+32 123 456 789</FormattedNumber></Telephone></root>"
            ],

        ];

        foreach ($tests as $test){
            $result = new Telephone(...$test['options']);
            $expected = $test['expected'];
            $xml = new \Spatie\ArrayToXml\ArrayToXml($result->getArray());
            \PHPUnit\Framework\assertSame($expected, $xml->dropXmlDeclaration()->toXml());

        }

    }


    public function testThrowErrorIfNoSubscriberNumber(): void
    {

        $this->expectException(\Throwable::class);
        $options = [
            'formattedNumber' => '+32 156 65120',
        ];
        $result = new Telephone(...$options);

    }

    public function testThrowErrorIfWrongSubscriberNumber(): void
    {

        $this->expectException(\UnexpectedValueException::class);
        $options = [
            'subscriberNumber' => '+32 156 65120',
        ];
        $result = new Telephone(...$options);

    }



}