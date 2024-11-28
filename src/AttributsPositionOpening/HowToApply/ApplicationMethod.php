<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\HowToApply;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\PostalAddress;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod\Telephone;

class ApplicationMethod
{

    protected ?Telephone $telephone = null;
    protected ?string $internetEmailAddress = null;
    protected ?string $internetWebAddress = null;

    protected ?PostalAddress $postalAddress = null;
    protected ?InPerson $inPerson = null;

    public function __construct(array $applicationMethod)
    {
        $this->setOptions($applicationMethod);
    }

    private function setOptions(array $applicationMethod): void
    {
        $this->telephone = isset($applicationMethod['telephone']) ? new Telephone($applicationMethod['telephone']) : null;
        $this->internetEmailAddress = $applicationMethod['internetEmailAddress'] ?? null;
        $this->postalAddress = $applicationMethod['postalAddress'] ? new PostalAddress($applicationMethod['postalAddress']) : null;
        $this->internetWebAddress = $applicationMethod['internetWebAddress'] ?? null;
        if (!$this->telephone && !$this->internetEmailAddress && !$this->postalAddress){
            throw new \InvalidArgumentException("Il faut définir au moins un téléphone, ou une adresse email, ou une adresse postale pour la candidature");
        }
        $this->inPerson = isset($applicationMethod['inPerson']) ? new InPerson($applicationMethod['inPerson']) : null;

    }

    public function getArray(): array
    {
        $array = [];
        if ($this->telephone){
            $array = array_merge($array, $this->telephone->getTelephoneArray());
        }
        if ($this->internetEmailAddress){
            $array['InternetEmailAddress'] = $this->internetEmailAddress;
        }
        if ($this->internetWebAddress){
            $array['InternetWebAddress'] = $this->internetWebAddress;
        }
        if ($this->postalAddress){
            $array = array_merge($array, $this->postalAddress->getPostalAddressArray());
        }

        return [
            'ApplicationMethod' => $array
        ];
    }
}