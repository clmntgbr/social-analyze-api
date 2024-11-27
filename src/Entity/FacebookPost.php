<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FacebookPostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacebookPostRepository::class)]
#[ApiResource()]
class FacebookPost extends Post
{
}