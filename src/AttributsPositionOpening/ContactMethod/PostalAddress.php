<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod;

use Mdpbriar\ForemApiPhpClient\Models\Pays;

class PostalAddress
{

    protected string $countryCode;
    protected string $postalCode;
    protected ?string $municipality = null;
    protected string $deliveryAddress;
//    @TODO: ajouter deliveryAddress et Recipient
    public function __construct(
        string $countryCode,
        string $postalCode,
        ?string $municipality = null,

    ){
        $this->setCountryCode($countryCode);
        $this->setPostalCode($postalCode);
        if ($municipality){
            $this->setMunicipality($municipality);
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

    public function getPostalCodeArray(): array
    {
        $contents = [
            "CountryCode" => $this->countryCode,
            "PostalCode" => $this->postalCode,
        ];

        if ($this->municipality){
            $contents["Municipality"] = $this->municipality;
        }

        return [
            'PostalAddress' => $contents,
        ];
    }

}