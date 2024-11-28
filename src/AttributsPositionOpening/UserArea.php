<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

use Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\UserArea\PublicationSubset;

class UserArea
{

    protected ?string $selectionProcedure = null;
    protected array $publicationSubsets = [];

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
        return [
            'UserArea' => $array
        ];
    }
}