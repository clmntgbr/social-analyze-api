<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\PostType;
use App\Repository\FacebookPostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacebookPostRepository::class)]
#[ApiResource()]
class FacebookPost extends Post
{
    public function __construct()
    {
        parent::__construct();
        $this->setPostType(PostType::FACEBOOK->toString());
    }
}