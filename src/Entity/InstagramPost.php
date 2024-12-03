<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\PlatformType;
use App\Repository\InstagramPostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstagramPostRepository::class)]
#[ApiResource()]
class InstagramPost extends Post
{
    public function __construct()
    {
        parent::__construct();
        $this->setPostType(sprintf('%s_post', PlatformType::INSTAGRAM->toString()));
    }
}