<?php

namespace App\Entity;

use App\Enum\PlatformType;
use App\Enum\SocialAccountType;
use App\Repository\YoutubeSocialAccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: YoutubeSocialAccountRepository::class)]
class YoutubeSocialAccount extends SocialAccount
{
    public function __construct()
    {
        parent::__construct();
        $this->setSocialAccountType(sprintf('%s_social_account', PlatformType::YOUTUBE->toString()));    }
}
