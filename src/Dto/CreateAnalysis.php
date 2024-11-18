<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateAnalysis
{
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    public ?string $username;

    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    public ?string $platform;

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'platform' => $this->platform,
        ];
    }
}