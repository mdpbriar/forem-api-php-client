<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Mdpbriar\ForemApiPhpClient\Enums\IdOwnerType;

class EntityId
{
    public function __construct(
        protected ?string $companyNumber,
        protected IdOwnerType|string|null $idOwnerType = IdOwnerType::PartnerCode
    ){
        $this->setEntityId($companyNumber, $idOwnerType);
    }

    public function setEntityId(string $companyNumber, IdOwnerType|string|null $idOwnerType): void
    {
        if (!$idOwnerType){
            $idOwnerType = IdOwnerType::PartnerCode;
        }
        if (!$idOwnerType instanceof IdOwnerType){
            $idOwnerType = IdOwnerType::from($idOwnerType);
        }
        $this->idOwnerType = $idOwnerType;
        $this->companyNumber = $companyNumber;

    }

    public function getSupplierArray(string $baliseName = 'SupplierId'): array
    {
        return [
            'SupplierId' => [
                '_attributes' => [
                    'idOwner' => $this->idOwnerType->value
                ],
                'IdValue' => $this->companyNumber,
            ]
        ];
    }

}