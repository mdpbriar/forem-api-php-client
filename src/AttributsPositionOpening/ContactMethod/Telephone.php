<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\ContactMethod;

class Telephone
{

    protected ?string $formattedNumber = null;
    protected ?string $internationalCountryCode = null;
    protected ?string $areaCityCode = null;
    protected string $subscriberNumber;
    public function __construct(
        string $subscriberNumber,
        ?string $formattedNumber = null,
        ?string $internationalCountryCode = null,
        ?string $areaCityCode = null,

    ){
        if ($formattedNumber) {
            $this->setFormattedNumber($formattedNumber);
        }
        if ($internationalCountryCode) {
            $this->setInternationalCountryCode($internationalCountryCode);
        }
        if ($areaCityCode) {
            $this->setAreaCityCode($areaCityCode);
        }
        $this->setSubscriberNumber($subscriberNumber);

    }

    public function validateDigits(string $internationalCountryCode): bool
    {
        $pattern = '/^[0-9]+$/';
        return preg_match($pattern, $internationalCountryCode);
    }

    public function validateSingleDigit(string $areaCityCode): bool
    {
        $pattern = '/^[0-9]$/';
        return preg_match($pattern, $areaCityCode);

    }
    public function setFormattedNumber(?string $formattedNumber): void
    {
        $this->formattedNumber = $formattedNumber;
    }

    public function setInternationalCountryCode(string $internationalCountryCode): void
    {
        # On enregistre le code pays uniquement si valide
        if ($this->validateDigits($internationalCountryCode)){
            $this->internationalCountryCode = $internationalCountryCode;
        }
    }

    public function setAreaCityCode(string $areaCityCode): void
    {
        if ($this->validateSingleDigit($areaCityCode)){
            $this->areaCityCode = $areaCityCode;
        }
    }

    public function setSubscriberNumber(string $subscriberNumber): void
    {
        if ($this->validateDigits($subscriberNumber)){
            $this->subscriberNumber = $subscriberNumber;
        } else {
            throw new \UnexpectedValueException("A phone number can only contains digits");
        }
    }


    public function getTelephoneArray(): array
    {
        $contents = [
            "SubscriberNumber" => $this->subscriberNumber,
        ];
        if ($this->internationalCountryCode){
            $contents["InternationalCountryCode"] = $this->internationalCountryCode;
        }
        if ($this->areaCityCode){
            $contents['AreaCityCode'] = $this->areaCityCode;
        }
        if ($this->formattedNumber){
            $contents['FormattedNumber'] = $this->formattedNumber;
        }
        return [
            'Telephone' => $contents,
        ];
    }

}