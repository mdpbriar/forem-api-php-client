<?php

namespace Mdpbriar\ForemApiPhpClient\AttributsPositionOpening\PositionProfile;

class Relocation
{

    protected ?bool $relocationConsidered = null;
    protected ?string $comments = null;
    public function __construct(array $relocation)
    {
        $this->setOptions($relocation);
    }

    private function setOptions(array $options): void
    {
        $this->relocationConsidered = $options['relocationConsidered'] ?? null;
        $this->comments = $options['comments'] ?? null;

    }

    public function getArray(): array
    {
        $array = [];

        if ($this->relocationConsidered !== null){
            $array['_attributes'] = ['relocationConsidered' => $this->relocationConsidered ? 'true':'false'];
        }

        if ($this->comments){
            $array['Comments'] = $this->comments;
        }

        return [
            'Relocation' => $array,
        ];
    }
}