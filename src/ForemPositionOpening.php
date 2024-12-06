<?php

namespace Mdpbriar\ForemApiPhpClient;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\EntityId;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\EntityName;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\FormattedPositionDescriptions;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\HowToApply;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\IdOffre;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\Organization;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionDateInfo;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionDetail;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\UserArea;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\StatusPosition;
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
    protected FormattedPositionDescriptions $formattedPositionDescriptions;
    protected HowToApply $howToApply;
    protected ?UserArea $userArea = null;

    public function __construct(array $options){

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
            physicalLocations: $options['positionDetail']['physicalLocations'],
            jobCategories: $options['positionDetail']['jobCategories'],
            positionTitle: $options['positionDetail']['positionTitle'],
            positionClassification: $options['positionDetail']['positionClassification'],
            positionSchedule: $options['positionDetail']['positionSchedule'],
            competencies: $options['positionDetail']['competencies'],
            userArea: $options['positionDetail']['experience'],
            shifts: $options['positionDetail']['shifts'] ?? null,
            remunerationPackage: $options['positionDetail']['remunerationPackage'] ?? null,
        );

        $this->setOptions($options);

    }



    private function setOptions(array $options): void
    {
        $required_fields = ['formattedDescriptions', 'howToApply'];

        foreach ($required_fields as $required_field){
            if (!isset($options[$required_field])){
                throw new \InvalidArgumentException("L'option '{$required_field}' n'est pas définie");
            }
        }

        # On récupère les descriptions dans les options
        $this->formattedPositionDescriptions = new FormattedPositionDescriptions($options['formattedDescriptions']);
        # On récupère les informations sur comment candidater
        $this->howToApply = new HowToApply($options['howToApply']);
        $this->userArea = isset($options['userArea']) ? new UserArea($options['userArea']) : null;

    }

    private function setPositionProfile(array $options): void
    {

    }


    public static function validate(array $options): array
    {
        try {
            $offre = new static($options);
            $offre->buildXml();
            return [
                'valid' => true,
                'message' => "Les données sont valides"
            ];
        } catch (\Throwable $e){
            return [
                'valid' => False,
                'message' => $e->getMessage()
            ];
        }

    }


    public function buildXml(): string
    {
        $positionProfile = [
            '_attributes' => [
                'xml:lang' => $this->lang,
            ],
            ...$this->positionDateInfo->getDatesArray(),
            ...$this->organization->getOrganizationArray(),
            ...$this->positionDetail->getArray(),
            ...$this->formattedPositionDescriptions->getFormattedDescriptionsArray(),
            ...$this->howToApply->getHowToApplyArray(),
        ];

        if ($this->userArea){
            $positionProfile = array_merge($positionProfile, $this->userArea->getArray());
        }
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
            'PositionProfile' => $positionProfile,
        ];
//        $arrayToXml = new ArrayToXml($array);

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