<?php

namespace App\Entity;

use App\Enum\PlatformType;
use App\Enum\SocialAccountType;
use App\Repository\TwitterSocialAccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TwitterSocialAccountRepository::class)]
class TwitterSocialAccount extends SocialAccount
{
    public function __construct()
    {
        parent::__construct();
        $this->setSocialAccountType(sprintf('%s_social_account', PlatformType::TWITTER->toString()));
    }
}
