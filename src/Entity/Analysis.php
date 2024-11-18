<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\ApiResource\Controller\GetAnalysesFavoritesAction;
use App\ApiResource\Controller\GetAnalysesRecentsAction;
use App\ApiResource\Controller\PostAnalysesAction;
use App\Entity\Traits\UuidTrait;
use App\Enum\AnalysisStatus;
use App\Repository\AnalysisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AnalysisRepository::class)]
#[ApiResource(
    operations: [
        new Post(
            controller: PostAnalysesAction::class,
        ),
        new Get(
            uriTemplate: '/analyses/recents',
            controller: GetAnalysesRecentsAction::class,

        ),
        new Get(
            uriTemplate: '/analysis/{uuid}',
            normalizationContext: ['skip_null_values' => false, 'groups' => ['analyses:full', 'social-accounts:full']],
        ),
        new Get(
            uriTemplate: '/analyses/favorites',
            controller: GetAnalysesFavoritesAction::class,

        ),
        new GetCollection(
            normalizationContext: ['skip_null_values' => false, 'groups' => ['analyses:full', 'social-accounts:full']],
        )
    ]
)]
class Analysis
{
    use UuidTrait;
    use TimestampableEntity;

    #[ORM\Column(type: Types::STRING)]
    #[Groups(['analyses:full'])]
    private ?string $title;

    #[ORM\Column(type: Types::STRING)]
    #[Groups(['analyses:full'])]
    private ?string $status;

    #[ORM\Column(type: Types::STRING)]
    #[Groups(['analyses:full'])]
    private ?string $username;

    #[ORM\Column(type: Types::STRING)]
    #[Groups(['analyses:full'])]
    private ?string $platform;

    #[ORM\ManyToOne(targetEntity: SocialAccount::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['analyses:full'])]
    private ?SocialAccount $socialAccount = null;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->status = AnalysisStatus::LOADING->toString();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    #[Groups(['analyses:full'])]
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    #[Groups(['analyses:full'])]
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getSocialAccount(): ?SocialAccount
    {
        return $this->socialAccount;
    }

    public function setSocialAccount(?SocialAccount $socialAccount): static
    {
        $this->socialAccount = $socialAccount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): static
    {
        $this->platform = $platform;

        return $this;
    }
}
