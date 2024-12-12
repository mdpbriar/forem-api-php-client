<?php

namespace ContactMethod;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\DeliveryAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use PHPUnit\Framework\TestCase;

final class PostalAddressTest extends TestCase
{
    public function testCreation(): void
    {

        $tests = [
            [
                'options' => [
                    'countryCode' => "BE",
                    'postalCode' => 5001,
                ],
                'expected' => "<root><PostalAddress><CountryCode>BE</CountryCode><PostalCode>5001</PostalCode></PostalAddress></root>"
            ],
            [
                'options' => [
                    'countryCode' => "BE",
                    'postalCode' => 1050,
                    'municipality' => "Ixelles",
                ],
                'expected' => "<root><PostalAddress><CountryCode>BE</CountryCode><PostalCode>1050</PostalCode><Municipality>Ixelles</Municipality></PostalAddress></root>"
            ],
            [
                'options' => [
                    'countryCode' => "BE",
                    'postalCode' => 1050,
                    'municipality' => "Ixelles",
                    'deliveryAddress' => [
                        "addressLine" => "chaussée d'Ixelles 168"
                    ],
                ],
                'expected' => "<root><PostalAddress><CountryCode>BE</CountryCode><PostalCode>1050</PostalCode><Municipality>Ixelles</Municipality><DeliveryAddress><AddressLine>chaussée d'Ixelles 168</AddressLine></DeliveryAddress></PostalAddress></root>"
            ],

        ];

        foreach ($tests as $test){
            $result = new PostalAddress($test['options']);
            $expected = $test['expected'];
            $xml = new \Spatie\ArrayToXml\ArrayToXml($result->getArray());
            \PHPUnit\Framework\assertSame($expected, $xml->dropXmlDeclaration()->toXml());

        }

    }


    public function testThrowErrorIfNoPostalCode(): void
    {

        $this->expectException(\InvalidArgumentException::class);
        $options = [
            'countryCode' => 'FR',
        ];
        $result = new PostalAddress($options);

    }

    public function testThrowErrorIfWrongCountryCode(): void
    {

        $this->expectException(\UnexpectedValueException::class);
        $options = [
            'countryCode' => 'FNEINBDFKHEB',
            'postalCode' => 5000
        ];
        $result = new PostalAddress($options);

    }


}