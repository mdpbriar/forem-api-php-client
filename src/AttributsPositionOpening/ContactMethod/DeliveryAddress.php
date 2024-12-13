<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod;

class DeliveryAddress
{

    /**
     * permet de préciser le nom de la rue ainsi que le numéro de l’adresse.
     *
     * @var string|null
     */
    protected ?string $addressLine = null;
    /**
     * permet de préciser le nom de la rue de l’adresse.
     *
     * @var string|null
     */
    protected ?string $streetName = null;
    /**
     * permet de préciser le numéro de l’adresse.
     *
     * @var string|null
     */
    protected ?string $buildingNumber = null;
    /**
     * permet de préciser le nom de l’immeuble de l’adresse
     *
     * @var string|null
     */
    protected ?string $unit = null;

    /**
     * permet de préciser la boîte postale de l’adresse.
     *
     * @var string|null
     */
    protected ?string $postOfficeBox = null;


    public function __construct(
        array $deliveryAddress
    )
    {
        $this->setOptions($deliveryAddress);
    }

    private function setOptions(array $options): void
    {
        $this->addressLine = $options['addressLine'] ?? null;
        $this->streetName = $options['streetName'] ?? null;
        $this->buildingNumber = $options['buildingNumber'] ?? null;
        $this->unit = $options['unit'] ?? null;
        $this->postOfficeBox = $options['postOfficeBox'] ?? null;

    }

    private function getAddressArray(): array
    {
        if ($this->addressLine){
            return [
                'AddressLine' => $this->addressLine
            ];
        }
        $array = [];
        if ($this->streetName){
            $array['StreetName'] = $this->streetName;
        }
        if ($this->buildingNumber){
            $array['BuildingNumber'] = $this->buildingNumber;
        }
        if ($this->unit){
            $array['Unit'] = $this->unit;
        }
        if ($this->postOfficeBox){
            $array['PostOfficeBox'] = $this->postOfficeBox;
        }
        return $array;

    }

    public function getArray(): array
    {

        return [
            'DeliveryAddress' => $this->getAddressArray()
        ];
    }
}