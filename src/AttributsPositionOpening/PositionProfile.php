<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\FormattedPositionDescriptions;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\HowToApply;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\Organization;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDateInfo;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\PositionDetail;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\UserArea;
use Mdpbriar\ForemApiPhpClient\ValidateOptions;

class PositionProfile
{
    public string $lang;
    protected PositionDateInfo $positionDateInfo;
    protected Organization $organization;
    protected PositionDetail $positionDetail;
    protected FormattedPositionDescriptions $formattedPositionDescriptions;
    protected HowToApply $howToApply;
    protected ?UserArea $userArea = null;
    public function __construct(array $positionProfile, ?string $lang = 'FR')
    {
        $this->lang = $lang;
        $this->setOptions($positionProfile);
    }

    private function setOptions(array $options): void
    {

        $required_fields = ['positionDetail', 'formattedDescriptions', 'howToApply'];
        ValidateOptions::validateArrayFields($options, $required_fields);

        $this->positionDateInfo = new PositionDateInfo(
            startDate: $options['startDate'] ?? null,
            expectedEndDate: $options['expectedEndDate'] ?? null,
            asSoonAsPossible: $options['asSoonAsPossible'] ?? null,
        );
        $this->organization = new Organization(
            organization: $options['organization'] ?? null,
        );
        $this->positionDetail = new PositionDetail($options['positionDetail']);
        $this->formattedPositionDescriptions = new FormattedPositionDescriptions($options['formattedDescriptions']);
        # On récupère les informations sur comment candidater
        $this->howToApply = new HowToApply($options['howToApply']);
        $this->userArea = isset($options['userArea']) ? new UserArea($options['userArea']) : null;

    }

    public function getArray(): array
    {
        $array = [
            '_attributes' => [
                'xml:lang' => $this->lang,
            ],
            ...$this->positionDateInfo->getArray(),
            ...$this->organization->getOrganizationArray(),
            ...$this->positionDetail->getArray(),
            ...$this->formattedPositionDescriptions->getArray(),
            ...$this->howToApply->getHowToApplyArray(),
        ];

        if ($this->userArea){
            $array = array_merge($array, $this->userArea->getArray());
        }

        return [
            'PositionProfile' => $array
        ];

    }
}