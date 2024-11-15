<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\Telephone;

class ContactMethod
{

    protected Telephone $telephone;
    protected ?Telephone $mobile = null;
    protected ?Telephone $fax = null;
    protected string $internetEmailAddress;
    protected string $internetWebAddress;
    protected PostalAddress $postalAddress;

    public function __construct(
        array $telephone,
        string $internetEmailAddress,
        string $internetWebAddress,
        array $postalAddress,
        ?array $mobile = null,
        ?array $fax = null,

    ){
        $this->telephone = new Telephone(
            subscriberNumber: $telephone['subscriberNumber'],
            formattedNumber: $telephone['formattedNumber'] ?? null,
            internationalCountryCode: $telephone['internationalCountryCode'] ?? null,
            areaCityCode: $telephone['areaCityCode'] ?? null,
        );
        $this->internetEmailAddress = $internetEmailAddress;
        $this->internetWebAddress = $internetWebAddress;
        $this->postalAddress = new PostalAddress(
            countryCode: $postalAddress['countryCode'],
            postalCode: $postalAddress['postalCode'],
            municipality: $postalAddress['municipality'] ?? null,
        );
        if ($mobile){
            $this->mobile = new Telephone(
                subscriberNumber: $mobile['subscriberNumber'],
                formattedNumber: $mobile['formattedNumber'] ?? null,
                internationalCountryCode: $mobile['internationalCountryCode'] ?? null,
                areaCityCode: $mobile['areaCityCode'] ?? null,
            );
        }
        if ($fax){
            $this->fax = new Telephone(
                subscriberNumber: $fax['subscriberNumber'],
                formattedNumber: $fax['formattedNumber'] ?? null,
                internationalCountryCode: $fax['internationalCountryCode'] ?? null,
                areaCityCode: $fax['areaCityCode'] ?? null,
            );
        }


    }


    public function getContactMethodArray(): array
    {
        $contactMethods = [
            ...$this->telephone->getTelephoneArray(),
        ];
        if ($this->mobile){
            $contactMethods = array_merge($contactMethods, $this->mobile->getTelephoneArray());
        }
        if ($this->fax){
            $contactMethods = array_merge($contactMethods, $this->fax->getTelephoneArray());
        }
        $contactMethods = array_merge($contactMethods, [
            "InternetEmailAddress" => $this->internetEmailAddress,
            "InternetWebAddress" => $this->internetWebAddress,
        ]);

        $contactMethods = array_merge($contactMethods, $this->postalAddress->getPostalCodeArray());

        return [
            'ContactMethod' => $contactMethods,
        ];
    }

}