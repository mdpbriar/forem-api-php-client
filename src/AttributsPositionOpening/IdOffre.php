<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening;

class IdOffre
{

    public function __construct(
        protected string|int $id_offre,
        protected string $partner_code
    ){}

    public function setIdOffre(string|int $id_offre): void
    {
        $this->id_offre = $id_offre;
    }

    public function getIdArray(): array
    {
        return [
            'Id' => [
                '_attributes' => ['idOwner' => $this->partner_code ],
                'IdValue' => $this->id_offre,
            ],
        ];
    }

}