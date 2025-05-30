<?php

namespace Mdpbriar\ForemApiPhpClient;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\EntityId;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\EntityName;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\IdOffre;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\NumberToFill;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\StatusPosition;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\UserArea;
use Spatie\ArrayToXml\ArrayToXml;


class ForemPositionOpening
{

    public string $lang = 'FR';
    protected IdOffre $idOffre;
    protected ?EntityName $entityName = null;
    protected StatusPosition $statusPosition;
    protected EntityId $supplierId;
    protected ContactMethod $contactMethod;

    protected PositionProfile $positionProfile;
    protected ?NumberToFill $numberToFill = null;
    protected ?UserArea $userArea = null;

    public function __construct(array $options){

        $this->setOptions($options);
    }



    private function setOptions(array $options): void
    {
        $required_fields = ['idOffre', 'partnerCode', 'positionProfile'];
        ValidateOptions::validateArrayFields($options, $required_fields);

        # On initialise le partner code
        # On ajoute l'ID offre
        $this->idOffre = new IdOffre($options['idOffre'], $options['partnerCode']);
        $this->statusPosition = new StatusPosition($options['validFrom'] ?? null, $options['validTo'] ?? null);
        $this->supplierId = new EntityId($options['companyNumber'] ?? $options['partnerCode'], $options['idOwner'] ?? null);
        $this->entityName = isset($options['entityName']) ? new EntityName($options['entityName']) : null;
        $this->contactMethod = new ContactMethod(
            telephone: $options['telephone'],
            internetEmailAddress: $options['internetEmailAddress'],
            internetWebAddress: $options['internetWebAddress'],
            postalAddress: $options['postalAddress'],
            mobile: $options['mobile'] ?? null,
            fax: $options['fax'] ?? null,
        );
        $this->positionProfile = new PositionProfile($options['positionProfile'], lang: $this->lang);
        $this->numberToFill = isset($options['numberToFill']) ? new NumberToFill($options['numberToFill']) : null;
        $this->userArea = isset($options['userArea']) ? new UserArea($options['userArea']) : null;


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
        $positionSupplier = [
            ...$this->supplierId->getArray(),
        ];
        if ($this->entityName){
            $positionSupplier = array_merge($positionSupplier, $this->entityName->getArray());
        }
        $positionSupplier = array_merge($positionSupplier, $this->contactMethod->getArray());

        $array = [
            'PositionRecordInfo' => [
                ...$this->idOffre->getArray(),
                ...$this->statusPosition->getArray(),
            ],
            'PositionSupplier' => $positionSupplier,
            ...$this->positionProfile->getArray(),
        ];
        if ($this->numberToFill){
            $array = array_merge($array, $this->numberToFill->getArray());
        }
        if ($this->userArea){
            $array = array_merge($array, $this->userArea->getArray());
        }
        return ArrayToXml::convert($array, [
            'rootElementName' => 'PositionOpening',
            '_attributes' => [
                'xml:lang' => $this->lang,
                'xmlns' => "http://ns.hr-xml.org/2006-02-28",
                'xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance"
            ],
        ], true, xmlEncoding: 'UTF-8', xmlVersion: '1.0');

    }

    public function buildAndValidateXML(): \DOMDocument
    {
        $path = __DIR__. DIRECTORY_SEPARATOR.'Forem-PositionOpening-5.2.xsd';
//        dd($path);

        $xml = new \DOMDocument();
        $xml->loadXML($this->buildXml());
        if (!$xml->schemaValidate($path)){
            throw new \DOMException("Le fichier xml n'est pas valide");
        }

        return $xml;
    }




}