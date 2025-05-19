<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\DeliveryAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\Recipient;
use Mdpbriar\ForemApiPhpClient\Models\Pays;
use Mdpbriar\ForemApiPhpClient\ValidateOptions;

class PhysicalLocation
{

    protected string $countryCode;
    protected string $postalCode;
    protected ?string $municipality = null;
    protected ?DeliveryAddress $deliveryAddress = null;
    protected ?Recipient $recipient = null;

    public function __construct(
        array $postalAddress,

    ){
        $this->setOptions($postalAddress);
    }

    public function setOptions(array $postalAddress): void
    {
        $required_fields = ['countryCode', 'postalCode'];
        ValidateOptions::validateArrayFields($postalAddress, $required_fields);
        $this->setCountryCode($postalAddress['countryCode']);
        $this->setPostalCode($postalAddress['postalCode']);
        if (isset($postalAddress['municipality'])){
            $this->setMunicipality($postalAddress['municipality']);
        }
        if (isset($postalAddress['deliveryAddress'])){
            $this->deliveryAddress = new DeliveryAddress($postalAddress['deliveryAddress']);
        }
        if (isset($postalAddress['recipient'])){
            $this->recipient = new Recipient($postalAddress['recipient']);
        }
    }

    public function setCountryCode(string $countryCode): void
    {
        if (Pays::validateCountryCode($countryCode)){
            $this->countryCode = $countryCode;
        } else {
            throw new \UnexpectedValueException("Le code pays n'est pas valide");
        }
    }
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function setMunicipality(string $municipality): void
    {
        $this->municipality = $municipality;
    }

    public function getArray(): array
    {
        $contents = [
            "CountryCode" => $this->countryCode,
            "PostalCode" => $this->postalCode,
        ];

        if ($this->municipality){
            $contents["Municipality"] = $this->municipality;
        }
        if ($this->deliveryAddress){
            $contents = array_merge($contents, $this->deliveryAddress->getArray());
        }
        if ($this->recipient){
            $contents = array_merge($contents, $this->recipient->getArray());
        }

        $custom_code = $this->postalCode .'-'. $this->municipality ?? '';

        return [
            "__custom:PhysicalLocation:{$custom_code}" => [
                "__custom:PostalAddress:{$custom_code}" => $contents,
            ],
        ];
    }

}