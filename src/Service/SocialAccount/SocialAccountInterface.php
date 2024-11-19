<?php

namespace App\Service\SocialAccount;

use App\Dto\ProfileInterface;

interface SocialAccountInterface
{
    public function getProfile(string $username);
    public function hydrate(ProfileInterface $profile);
    public function isProfileExist(string $username): bool;
}