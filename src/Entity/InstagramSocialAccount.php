<?php

namespace App\Entity;

use App\Enum\PlatformType;
use App\Enum\SocialAccountType;
use App\Repository\InstagramSocialAccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstagramSocialAccountRepository::class)]
class InstagramSocialAccount extends SocialAccount
{
    public function __construct()
    {
        parent::__construct();
        $this->setSocialAccountType(sprintf('%s_social_account', PlatformType::INSTAGRAM->toString()));    }
}
