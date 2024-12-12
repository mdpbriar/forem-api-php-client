<?php


use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\DeliveryAddress;
use PHPUnit\Framework\TestCase;

final class PersonNameTest extends TestCase
{
    public function testCreation(): void
    {

        $tests = [
            [
                'options' => [
                    'preferredGivenName' => "Jean-Paul",
                    'familyName' => 'Sartre',
                ],
                'expected' => "<root><PersonName><PreferredGivenName>Jean-Paul</PreferredGivenName><FamilyName>Sartre</FamilyName></PersonName></root>"
            ],
            [
                'options' => [
                    'preferredGivenName' => "Alfred",
                    'familyName' => 'Dreyfus',
                    'formattedName' => 'Alfred DREYFUS'
                ],
                'expected' => "<root><PersonName><FormattedName>Alfred DREYFUS</FormattedName><PreferredGivenName>Alfred</PreferredGivenName><FamilyName>Dreyfus</FamilyName></PersonName></root>"
            ],

        ];

        foreach ($tests as $test){
            $result = new \Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PersonName($test['options']);
            $expected = $test['expected'];
            $xml = new \Spatie\ArrayToXml\ArrayToXml($result->getArray());
            \PHPUnit\Framework\assertSame($expected, $xml->dropXmlDeclaration()->toXml());

        }

    }

}