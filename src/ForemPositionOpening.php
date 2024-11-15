<?php

namespace Mdpbriar\ForemApiPhpClient;

use Carbon\Carbon;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod;
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
    protected IdOffre $idOffre;
    protected EntityName $entityName;
    protected StatusPosition $statusPosition;
    protected SupplierId $supplierId;
    protected ContactMethod $contactMethod;

    public function __construct(array $options){
        if (!$this->validate($options)){
            throw new \RuntimeException("Les options ne sont pas valides");
        }
        # On initialise le partner code
        # On ajoute l'ID offre
        $this->idOffre = new IdOffre($options['idOffre'], $options['partnerCode']);
        $this->statusPosition = new StatusPosition($options['validFrom'] ?? null, $options['validTo'] ?? null);
        $this->supplierId = new SupplierId($options['companyNumber'] ?? $options['partnerCode'], $options['idOwner'] ?? null);
        $this->entityName = new EntityName($options['entityName'] ?? null);
        $this->contactMethod = new ContactMethod(
            telephone: $options['telephone'],
            internetEmailAddress: $options['internetEmailAddress'],
            internetWebAddress: $options['internetWebAddress'],
            postalAddress: $options['postalAddress'],
            mobile: $options['mobile'] ?? null,
            fax: $options['fax'] ?? null,
        );

    }


    public static function validate(array $options): bool
    {
        if (!isset($options['partnerCode'], $options['idOffre'])){
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
                ...$this->contactMethod->getContactMethodArray(),
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