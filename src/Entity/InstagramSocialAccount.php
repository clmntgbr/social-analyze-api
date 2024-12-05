<?php

namespace App\Entity;

use App\Enum\PlatformType;
use App\Repository\InstagramSocialAccountRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: InstagramSocialAccountRepository::class)]
class InstagramSocialAccount extends SocialAccount
{
    #[ORM\Column(type: Types::BOOLEAN, unique: false)]
    #[Groups(['social-accounts:full'])]
    private bool $isPrivate = false;

    #[ORM\Column(type: Types::STRING, unique: false)]
    #[Groups(['social-accounts:full'])]
    private ?string $category;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['social-accounts:full', 'analyses:openAi'])]
    private ?int $playCount = null;

    public function __construct()
    {
        parent::__construct();
        $this->setSocialAccountType(sprintf('%s_social_account', PlatformType::INSTAGRAM->toString()));
    }

    public function isPrivate(): ?bool
    {
        return $this->isPrivate;
    }

    public function setPrivate(bool $isPrivate): static
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPlayCount(): ?int
    {
        return $this->playCount;
    }

    public function setPlayCount(?int $playCount): static
    {
        $this->playCount = $playCount;

        return $this;
    }
}
