<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class GetAnalysis
{
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    public ?string $uuid;
}