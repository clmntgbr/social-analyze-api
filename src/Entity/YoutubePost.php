<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\PostType;
use App\Repository\YoutubePostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: YoutubePostRepository::class)]
#[ApiResource()]
class YoutubePost extends Post
{
    public function __construct()
    {
        parent::__construct();
        $this->setPostType(PostType::YOUTUBE->toString());
    }
}