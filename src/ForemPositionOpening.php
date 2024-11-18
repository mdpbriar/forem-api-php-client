<?php

namespace Mdpbriar\ForemApiPhpClient;

use Carbon\Carbon;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\EntityName;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\IdOffre;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\JobCategories;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\Organization;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionDateInfo;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionDetail;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\StatusPosition;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\EntityId;
use Mdpbriar\ForemApiPhpClient\Enums\IdOwnerType;
use Mdpbriar\ForemApiPhpClient\Enums\PositionRecordStatus;
use Spatie\ArrayToXml\ArrayToXml;



class ForemPositionOpening
{

    public string $lang = 'FR';
    protected IdOffre $idOffre;
    protected EntityName $entityName;
    protected StatusPosition $statusPosition;
    protected EntityId $supplierId;
    protected ContactMethod $contactMethod;
    protected PositionDateInfo $positionDateInfo;
    protected Organization $organization;
    protected PositionDetail $positionDetail;

    public function __construct(array $options){
        if (!self::validate($options)){
            throw new \RuntimeException("Les options ne sont pas valides");
        }
        # On initialise le partner code
        # On ajoute l'ID offre
        $this->idOffre = new IdOffre($options['idOffre'], $options['partnerCode']);
        $this->statusPosition = new StatusPosition($options['validFrom'] ?? null, $options['validTo'] ?? null);
        $this->supplierId = new EntityId($options['companyNumber'] ?? $options['partnerCode'], $options['idOwner'] ?? null);
        $this->entityName = new EntityName($options['entityName'] ?? null);
        $this->contactMethod = new ContactMethod(
            telephone: $options['telephone'],
            internetEmailAddress: $options['internetEmailAddress'],
            internetWebAddress: $options['internetWebAddress'],
            postalAddress: $options['postalAddress'],
            mobile: $options['mobile'] ?? null,
            fax: $options['fax'] ?? null,
        );
        $this->positionDateInfo = new PositionDateInfo(
            startDate: $options['startDate'] ?? null,
            expectedEndDate: $options['expectedEndDate'] ?? null,
            asSoonAsPossible: $options['asSoonAsPossible'] ?? null,
        );
        $this->organization = new Organization(
            organization: $options['organization'] ?? null,
        );
        $this->positionDetail = new PositionDetail(
            industryCode: $options['positionDetail']['industryCode'],
            physicalLocation: $options['positionDetail']['physicalLocation'],
            jobCategories: $options['positionDetail']['jobCategories'],
            positionTitle: $options['positionDetail']['positionTitle'],
            positionClassification: $options['positionDetail']['positionClassification'],
            positionSchedule: $options['positionDetail']['positionSchedule'],
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
            'PositionProfile' => [
                '_attributes' => [
                    'xml:lang' => $this->lang,
                ],
                ...$this->positionDateInfo->getDatesArray(),
                ...$this->organization->getOrganizationArray(),
                ...$this->positionDetail->getPositionDetailArray(),
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