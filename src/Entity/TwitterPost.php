<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\PlatformType;
use App\Enum\PostType;
use App\Repository\TwitterPostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TwitterPostRepository::class)]
#[ApiResource()]
class TwitterPost extends Post
{
    public function __construct()
    {
        parent::__construct();
        $this->setPostType(sprintf('%s_post', PlatformType::TWITTER->toString()));
    }
}