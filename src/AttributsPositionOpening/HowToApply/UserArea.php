<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\HowToApply;

class UserArea
{
    protected ?string $comments = null;
    protected ?string $contentPostedInformation = null;

    public function __construct(
        array $userArea
    )
    {
        $this->setOptions($userArea);
    }

    private function setOptions(array $userArea): void
    {
        $this->comments = $userArea['comments'] ?? null;
        $this->contentPostedInformation = $userArea['contentPostedInformation'] ?? null;
    }

    public function getArray(): array
    {
        $array = [];
        if ($this->comments){
            $array['Comments'] = ['_cdata' => $this->comments];
        }
        if ($this->contentPostedInformation){
            $array['ContentPostedInformation'] = ['_cdata' => $this->contentPostedInformation];
        }

        return [
            'UserArea' => $array,
        ];
    }
}