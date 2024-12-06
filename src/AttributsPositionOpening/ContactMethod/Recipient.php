<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PersonName;

class Recipient
{

    protected ?string $organizationName = null;
    protected ?PersonName $personName = null;
    public function __construct(
        array $recipient
    )
    {
        $this->setOptions($recipient);
    }

    private function setOptions(array $options): void
    {
        $this->organizationName = $options['organizationName'] ?? null;
        $this->personName = isset($options['personName']) ? new PersonName($options['personName']) : null;
    }

    public function getArray(): array
    {
        $array = [];
        if ($this->organizationName){
            $array['OrganizationName'] = $this->organizationName;
        }
        if ($this->personName){
            $array = array_merge($array, $this->personName->getArray());
        }
        return [
            'Recipient' => $array
        ];
    }
}