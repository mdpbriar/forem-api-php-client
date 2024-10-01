<?php

namespace Mdpbriar\ForemApiPhpClient;

use Carbon\Carbon;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\EntityName;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\IdOffre;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\StatusPosition;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\SupplierId;
use Mdpbriar\ForemApiPhpClient\Enums\IdOwnerType;
use Mdpbriar\ForemApiPhpClient\Enums\PositionRecordStatus;
use Spatie\ArrayToXml\ArrayToXml;



class ForemPositionOpening
{

    public string $lang = 'FR';
    protected string $partnerCode;



    protected IdOffre $idOffre;
    protected EntityName $entityName;
    protected StatusPosition $statusPosition;
    protected SupplierId $supplierId;

    protected array $telephone = [];

    public function __construct(array $options){
        $configs = include('config.php');
        if (!$configs['partnerCode']){
            throw new \RuntimeException("PartnerCode isn't set");
        }
        if (!$this->validate($options)){
            throw new \RuntimeException("Les options ne sont pas valides");
        }
        # On initialise le partner code
        $this->partnerCode = $configs['partnerCode'];
        # On ajoute l'ID offre
        $this->idOffre = new IdOffre($options['id_offre'], $this->partnerCode);

        $this->statusPosition = new StatusPosition($options['validFrom'] ?? null, $options['validTo'] ?? null);

        $this->supplierId = new SupplierId($options['company_number'] ?? $this->partnerCode, $options['id_owner'] ?? null);


        # On ajoute une entity name
        $this->entityName = new EntityName($options['entityName'] ?? null);

    }


    public function validate(array $options): bool
    {
        if (!isset($options['id_offre'])){
            return false;
        }
        return true;

    }


    public function buildXml(): string
    {
        $array = [
            'PositionRecordInfo' => [
                ...$this->idOffre->getIdArray(),
                ...$this->statusPosition->getStatusArray(),
            ],
            'PositionSupplier' => [
                ...$this->supplierId->getSupplierArray(),
                ...$this->entityName?->getEntityNameArray(),
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