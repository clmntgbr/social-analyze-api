<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class PostAnalysisFavorites
{

    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    public ?string $uuid;

    #[Assert\Type('bool')]
    public ?bool $status = null;

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
        ];
    }
}