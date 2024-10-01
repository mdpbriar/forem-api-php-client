<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

class EntityName
{

    public function __construct(
        protected ?string $entityName = null
    ){}

    public function setEntityName(string $entityName): void
    {
        $this->entityName = $entityName;
    }

    public function getEntityNameArray(): array
    {
        if (!$this->entityName) {
            return [];
        }

        return [
            'EntityName' => [
                '_cdata' => $this->entityName,
            ]
        ];
    }

}