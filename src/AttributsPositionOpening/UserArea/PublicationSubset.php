<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\UserArea;

use Mdpbriar\ForemApiPhpClient\ValidateOptions;

class PublicationSubset
{
    protected string $name;
    protected bool $value;

    public function __construct(
        array $publicationSubset
    )
    {
        $this->setOptions($publicationSubset);
    }

    private function setOptions(array $publicationSubset): void
    {
        $required_fields = ['name', 'value'];
        ValidateOptions::validateArrayFields($publicationSubset,$required_fields);
        $this->name = $publicationSubset['name'];
        $this->value = $publicationSubset['value'];
    }

    public function getArray(): array
    {
        return [
            "_custom:PublicationSubset:{$this->name}" => [
                '_attributes' => [
                    'name' => $this->name
                ],
                '_value' => $this->value ? 'true' : 'false',
            ]
        ];
    }
}