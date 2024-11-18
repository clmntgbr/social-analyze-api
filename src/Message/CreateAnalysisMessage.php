<?php

namespace App\Message;

final class CreateAnalysisMessage
{
    public function __construct(
        private ?string $username,
        private ?string $platform
    ){}

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }
}
