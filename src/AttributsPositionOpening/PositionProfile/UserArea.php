<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\UserArea\ActiveMediation;
use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile\UserArea\PublicationSubset;

class UserArea
{

    protected ?string $selectionProcedure = null;
    protected array $publicationSubsets = [];

    protected ?ActiveMediation $activeMediation = null;
    protected ?string $comments = null;

    public function __construct(
        array $userArea
    )
    {
        $this->setOptions($userArea);
    }

    private function setOptions(array $options): void
    {
        $this->selectionProcedure = $options['selectionProcedure'] ?? null;
        if (isset($options['publicationSubsets'])){
            $this->publicationSubsets = array_map(function(array $publicationSubset){
                return new PublicationSubset($publicationSubset);
            }, $options['publicationSubsets']);
        }
        $this->activeMediation = isset($options['activeMediation']) ? new ActiveMediation($options['activeMediation']) : null;
        $this->comments = $options['comments'] ?? null;


    }

    public function getArray(): array
    {
        $array = [];
        if ($this->selectionProcedure){
            $array['SelectionProcedure'] = ['_cdata' => $this->selectionProcedure];
        }
        if (count($this->publicationSubsets)){
            $array = array_merge(
                $array, ...array_map(function(PublicationSubset $publicationSubset){
                    return $publicationSubset->getArray();
                }, $this->publicationSubsets)
            );
        }
        if ($this->activeMediation){
            $array = array_merge($array, $this->activeMediation->getArray());
        }
        if ($this->comments){
            $array['Comments'] = ['_cdata' => $this->comments];
        }
        return [
            'UserArea' => $array
        ];
    }
}