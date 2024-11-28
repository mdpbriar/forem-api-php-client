<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

class EntityName
{

    protected string $entityName;
    public function __construct(
        string $entityName
    ){
        $this->setEntityName($entityName);
    }

    public function setEntityName(string $entityName): void
    {
        $this->entityName = $entityName;
    }

    public function getArray(): array
    {

        return [
            'EntityName' => [
                '_cdata' => $this->entityName,
            ]
        ];
    }

}