<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TwitterPostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TwitterPostRepository::class)]
#[ApiResource()]
class TwitterPost extends Post
{
}