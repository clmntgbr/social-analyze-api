<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\UuidTrait;
use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    operations: [],
    order: ['createdAt' => 'DESC']
)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'linkedin_post' => 'LinkedinPost',
    'twitter_post' => 'TwitterPost',
    'facebook_post' => 'FacebookPost',
    'youtube_post' => 'YoutubePost',
    'instagram_post' => 'InstagramPost',
])]
#[ApiFilter(SearchFilter::class, properties: ['status' => 'exact'])]
class Post
{
    use UuidTrait;
    use TimestampableEntity;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $postId = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['social-accounts:full', 'analyses:openAi'])]
    private ?string $body = null;

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['social-accounts:full'])]
    private array $images = [];

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['social-accounts:full', 'analyses:openAi'])]
    private ?int $likeCount = 0;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['social-accounts:full', 'analyses:openAi'])]
    private ?int $commentsCount = 0;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['social-accounts:full', 'analyses:openAi'])]
    private ?int $repostsCount = 0;

    #[ORM\Column(type: Types::FLOAT)]
    #[Groups(['social-accounts:full', 'analyses:openAi'])]
    private ?float $engagementRate = 0;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $url = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['social-accounts:full', 'analyses:openAi'])]
    private ?\DateTime $postAt = null;

    #[ORM\ManyToOne(targetEntity: SocialAccount::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SocialAccount $socialAccount = null;

    #[ORM\Column(type: Types::STRING)]
    #[Groups(['social-accounts:full', 'analyses:openAi'])]
    private string $postType;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
    }

    public function getPostId(): ?string
    {
        return $this->postId;
    }

    public function setPostId(?string $postId): static
    {
        $this->postId = $postId;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getLikeCount(): ?int
    {
        return $this->likeCount;
    }

    public function setLikeCount(int $likeCount): static
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    public function getCommentsCount(): ?int
    {
        return $this->commentsCount;
    }

    public function setCommentsCount(int $commentsCount): static
    {
        $this->commentsCount = $commentsCount;

        return $this;
    }

    public function getRepostsCount(): ?int
    {
        return $this->repostsCount;
    }

    public function setRepostsCount(int $repostsCount): static
    {
        $this->repostsCount = $repostsCount;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getPostAt(): ?\DateTimeInterface
    {
        return $this->postAt;
    }

    public function setPostAt(?\DateTimeInterface $postAt): static
    {
        $this->postAt = $postAt;

        return $this;
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

    public function getEngagementRate(): ?float
    {
        return $this->engagementRate;
    }

    public function setEngagementRate(float $engagementRate): static
    {
        $this->engagementRate = $engagementRate;

        return $this;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getPostType(): ?string
    {
        return $this->postType;
    }

    public function setPostType(string $postType): static
    {
        $this->postType = $postType;

        return $this;
    }
}
