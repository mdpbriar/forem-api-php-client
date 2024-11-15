<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Carbon\Carbon;
use Mdpbriar\ForemApiPhpClient\Enums\PositionRecordStatus;

class Organization
{

    protected ?string $organizationName = null;
    protected ?EntityId $legalId = null;
    protected ContactMethod $contactMethod;
    public function __construct(
        array $organization,
    ){
        if (isset($organization['organizationName'])){
            $this->organizationName = $organization['organizationName'];
        }
        if (isset($organization['legalId'])){
            $this->legalId = new EntityId(companyNumber: $organization['legalId']['companyNumber'], idOwnerType: $organization['legalId']['idOwnerType']);
        }
        $contactMethod = $organization['contactMethod'];
        $this->contactMethod = new ContactMethod(
            telephone: $contactMethod['telephone'],
            internetEmailAddress: $contactMethod['internetEmailAddress'],
            internetWebAddress: $contactMethod['internetWebAddress'],
            postalAddress: $contactMethod['postalAddress'],
            mobile: $contactMethod['mobile'] ?? null,
            fax: $contactMethod['fax'] ?? null,
        );

    }

    public function getOrganizationArray(): ?array
    {
        $contents = [];
        if ($this->organizationName){
            $contents['OrganizationName'] = $this->organizationName;
        }
        if ($this->legalId){
            $contents = array_merge($contents, $this->legalId->getSupplierArray('LegalId'));
        }
        $contents = array_merge($contents, ['ContactInfo' => $this->contactMethod->getContactMethodArray()]);

        return [
            'Organization' => $contents,
        ];
    }

}