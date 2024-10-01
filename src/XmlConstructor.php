<?php

namespace Mdpbriar\ForemApiPhpClient;

use Carbon\Carbon;
use Mdpbriar\ForemApiPhpClient\Enums\IdOwnerType;
use Mdpbriar\ForemApiPhpClient\Enums\PositionRecordStatus;
use Spatie\ArrayToXml\ArrayToXml;



class XmlConstructor
{

    public string $lang = 'FR';

    protected array $attributes = [];
    protected string $partnerCode;
    protected string|int|null $id_offre = null;
    protected ?string $statut = null;
    protected ?string $validFrom = null;
    protected ?string $validTo = null;
    protected ?string $supplierId = null;
    protected ?string $companyNumber = null;

    public function __construct(string|int|null $id_offre = null){
        $configs = include('config.php');
        if (!$configs['partnerCode']){
            throw new \RuntimeException("PartnerCode isn't set");
        }
        if ($id_offre){
            $this->setIdOffre($id_offre);
        }
        $this->partnerCode = $configs['partnerCode'];

    }


    public function setIdOffre(string|int $id_offre): void
    {
        $this->id_offre = $id_offre;
    }

    private function getIdArray(): array
    {


        if (!$this->id_offre){
            throw new \RuntimeException("Offer ID isn't filled");
        }
        return [
            'Id' => [
                '_attributes' => ['idOwner' => $this->partnerCode ],
                'IdValue' => $this->id_offre,
            ],
        ];
    }

    public function setStatus(Carbon|string $validFrom, Carbon|string $validTo, PositionRecordStatus|string|null $statut = null): void
    {
        if (!$statut){
            $statut = PositionRecordStatus::Active;
        }
        if (is_string($statut)){
            $statut = PositionRecordStatus::from($statut);
        }
        if (is_string($validFrom)){
            $validFrom = Carbon::parse($validFrom);
        }
        if (is_string($validTo)){
            $validTo = Carbon::parse($validTo);
        }

        $this->statut = $statut->value;
        $this->validFrom = $validFrom->format('Y-m-d');
        $this->validTo = $validTo->format('Y-m-d');
    }

    private function getStatusArray(): ?array
    {
        $attributes = [];
        if ($this->validTo && $this->validFrom){
            $attributes = [
                'validFrom' => $this->validFrom,
                'validTo' => $this->validTo,
            ];
        }
        return [
            'Status' => [
                '_attributes' => $attributes,
                '_value' => $this->statut ?? PositionRecordStatus::Active->value,
            ],
        ];
    }

    public function setSupplierId(IdOwnerType|string|null $idOwnerType, string|null $companyNumber): void
    {
        if (!$idOwnerType instanceof IdOwnerType){
            $idOwnerType = IdOwnerType::from($idOwnerType);
        }
        $this->supplierId = $idOwnerType->value;
        $this->companyNumber = $companyNumber;

    }

    private function getSupplierArray(): array
    {
        return [
            'SupplierId' => [
                '_attributes' => [
                    'idOwner' => $this->supplierId ?? IdOwnerType::PartnerCode->value
                ],
                'IdValue' => $this->companyNumber ?? $this->partnerCode,
            ]
        ];
    }


    public function buildXml(): string
    {
        $array = [
            'PositionRecordInfo' => [
                ...$this->getIdArray(),
                ...$this->getStatusArray()
            ],
            'PositionSupplier' => [
                ...$this->getSupplierArray(),
            ],
        ];
        return ArrayToXml::convert($array, [
            'rootElementName' => 'PositionOpening',
            '_attributes' => [
                'xml:lang' => $this->lang,
                'xmlns' => "http://ns.hr-xml.org/2006-02-28",
                'xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance"
            ],
        ], true, xmlEncoding: 'UTF-8', xmlVersion: '1.0');

    }

}