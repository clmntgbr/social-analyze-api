<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\SocialAccountType;
use App\Repository\LinkedinSocialAccountRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: LinkedinSocialAccountRepository::class)]
#[ApiResource()]
class LinkedinSocialAccount extends SocialAccount
{
    #[ORM\Column(type: Types::BOOLEAN)]
    #[Groups(['social-accounts:full'])]
    private bool $isOpenToWork;

    #[ORM\Column(type: Types::BOOLEAN)]
    #[Groups(['social-accounts:full'])]
    private bool $isHiring;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $summary = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $headline = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $country = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $city = null;

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['social-accounts:full'])]
    private array $languages;

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['social-accounts:full'])]
    private array $skills;

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['social-accounts:full'])]
    private array $educations;

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['social-accounts:full'])]
    private array $positions;

    #[ORM\Column(type: Types::JSON)]
    private array $payload;

    public function __construct()
    {
        parent::__construct();
        $this->isOpenToWork = false;
        $this->isHiring = false;
        $this->languages = [];
        $this->educations = [];
        $this->payload = [];
        $this->positions = [];
        $this->setSocialAccountType(SocialAccountType::LINKEDIN->toString());
    }

    public function getIsOpenToWork(): ?bool
    {
        return $this->isOpenToWork;
    }

    public function setOpenToWork(bool $isOpenToWork): static
    {
        $this->isOpenToWork = $isOpenToWork;

        return $this;
    }

    public function getIsHiring(): ?bool
    {
        return $this->isHiring;
    }

    public function setHiring(bool $isHiring): static
    {
        $this->isHiring = $isHiring;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getHeadline(): ?string
    {
        return $this->headline;
    }

    public function setHeadline(?string $headline): static
    {
        $this->headline = $headline;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function setLanguages(array $languages): static
    {
        $this->languages = $languages;

        return $this;
    }

    public function getEducations(): array
    {
        return $this->educations;
    }

    public function setEducations(array $educations): static
    {
        $this->educations = $educations;

        return $this;
    }

    public function getPositions(): array
    {
        return $this->positions;
    }

    public function setPositions(array $positions): static
    {
        $this->positions = $positions;

        return $this;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function setPayload(array $payload): static
    {
        $this->payload = $payload;

        return $this;
    }

    public function isOpenToWork(): ?bool
    {
        return $this->isOpenToWork;
    }

    public function isHiring(): ?bool
    {
        return $this->isHiring;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }

    public function setSkills(array $skills): static
    {
        $this->skills = $skills;

        return $this;
    }
}
