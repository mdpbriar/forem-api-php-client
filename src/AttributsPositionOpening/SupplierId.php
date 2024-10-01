<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Mdpbriar\ForemApiPhpClient\Enums\IdOwnerType;

class SupplierId
{
    public function __construct(
        protected ?string $companyNumber,
        protected IdOwnerType|string|null $supplierId = IdOwnerType::PartnerCode
    ){
        $this->setSupplierId($companyNumber, $supplierId);
    }

    public function setSupplierId(string $companyNumber, IdOwnerType|string|null $idOwnerType): void
    {
        if (!$idOwnerType){
            $idOwnerType = IdOwnerType::PartnerCode;
        }
        if (!$idOwnerType instanceof IdOwnerType){
            $idOwnerType = IdOwnerType::from($idOwnerType);
        }
        $this->supplierId = $idOwnerType;
        $this->companyNumber = $companyNumber;

    }

    public function getSupplierArray(): array
    {
        return [
            'SupplierId' => [
                '_attributes' => [
                    'idOwner' => $this->supplierId->value
                ],
                'IdValue' => $this->companyNumber,
            ]
        ];
    }

}