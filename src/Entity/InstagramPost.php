<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\PlatformType;
use App\Repository\InstagramPostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: InstagramPostRepository::class)]
#[ApiResource()]
class InstagramPost extends Post
{
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['social-accounts:full', 'analyses:openAi'])]
    private ?int $playCount = 0;

    public function __construct()
    {
        parent::__construct();
        $this->setPostType(sprintf('%s_post', PlatformType::INSTAGRAM->toString()));
    }

    public function getPlayCount(): ?int
    {
        return $this->playCount;
    }

    public function setPlayCount(int $playCount): static
    {
        $this->playCount = $playCount;

        return $this;
    }
}