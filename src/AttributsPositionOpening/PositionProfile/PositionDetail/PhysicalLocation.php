<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\DeliveryAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\Recipient;
use Mdpbriar\ForemApiPhpClient\Models\Pays;
use Mdpbriar\ForemApiPhpClient\ValidateOptions;

class PhysicalLocation
{

    protected ?PostalAddress $postalAddress;

    public function __construct(
        array $postalAddress,

    ){
        $this->postalAddress = new PostalAddress($postalAddress);
    }


    public function getArray(): array
    {
        $array = [];
        $array = array_merge($array, $this->postalAddress->getArray());
        return ['PhysicalLocation' => $array];
    }

}