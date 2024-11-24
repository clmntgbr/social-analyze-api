<?php

namespace App\Message;

final readonly class CreateAnalysisMessage
{
    public function __construct(
        private ?string          $username,
        private ?string          $platform,
        private array            $payload
    ){}

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }
}
