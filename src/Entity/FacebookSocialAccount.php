<?php

namespace App\Entity;

use App\Enum\PlatformType;
use App\Enum\SocialAccountType;
use App\Repository\FacebookSocialAccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacebookSocialAccountRepository::class)]
class FacebookSocialAccount extends SocialAccount
{
    public function __construct()
    {
        parent::__construct();
        $this->setSocialAccountType(sprintf('%s_social_account', PlatformType::FACEBOOK->toString()));
    }
}
