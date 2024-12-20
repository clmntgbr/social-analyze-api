<?php

namespace App\Service\SocialAccount;

interface SocialAccountInterface
{
    public function getProfile(string $username): ?array;
    public function hydrate(array $payload);
}