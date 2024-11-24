<?php

namespace App\Service\SocialAccount;

class TwitterSocialAccountService implements SocialAccountInterface
{
    public function getProfile(string $username): ?array
    {
        // TODO: Implement getProfile() method.
    }

    public function isProfileExist(string $username): bool
    {
        return true;
    }

    public function hydrate(array $payload)
    {
        // TODO: Implement getProfile() method.
    }
}