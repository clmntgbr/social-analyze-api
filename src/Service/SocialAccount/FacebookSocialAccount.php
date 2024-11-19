<?php

namespace App\Service\SocialAccount;

use App\Dto\Linkedin\LinkedinProfile;
use App\Dto\ProfileInterface;

class FacebookSocialAccount implements SocialAccountInterface
{
    public function getProfile(string $username)
    {
        // TODO: Implement getProfile() method.
    }

    public function isProfileExist(string $username): bool
    {
        return true;
    }

    /** @param LinkedinProfile $profile */
    public function hydrate(ProfileInterface $profile)
    {
        // TODO: Implement getProfile() method.
    }
}