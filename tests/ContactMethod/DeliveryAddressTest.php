<?php

namespace ContactMethod;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\DeliveryAddress;
use PHPUnit\Framework\TestCase;

final class DeliveryAddressTest extends TestCase
{
    public function testCreation(): void
    {

        $tests = [
            [
                'deliveryAddress' => [
                    'addressLine' => "23 rue des platanes",
                    'streetName' => 'rue des platanes',
                ],
                'expected' => "<root><DeliveryAddress><AddressLine>23 rue des platanes</AddressLine></DeliveryAddress></root>"
            ],
            [
                'deliveryAddress' => [
                    'buildingNumber' => 23,
                    'streetName' => 'rue des platanes',
                ],
                'expected' => "<root><DeliveryAddress><StreetName>rue des platanes</StreetName><BuildingNumber>23</BuildingNumber></DeliveryAddress></root>"
            ],

        ];

        foreach ($tests as $test){
            $result = new DeliveryAddress($test['deliveryAddress']);
            $expected = $test['expected'];
            $xml = new \Spatie\ArrayToXml\ArrayToXml($result->getArray());
            \PHPUnit\Framework\assertSame($expected, $xml->dropXmlDeclaration()->toXml());

        }

    }


    public function testThrowError(): void
    {

        $this->expectException(\Throwable::class);
        $result = new DeliveryAddress();

    }


}