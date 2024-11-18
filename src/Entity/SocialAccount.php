<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\UuidTrait;
use App\Repository\SocialAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SocialAccountRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'linkedin_social_account' => 'LinkedinSocialAccount',
    'twitter_social_account' => 'TwitterSocialAccount',
    'facebook_social_account' => 'FacebookSocialAccount',
])]
#[ApiResource(
    operations: []
)]
#[ApiFilter(SearchFilter::class, properties: ['socialAccountType' => 'exact'])]
class SocialAccount
{
    use UuidTrait;
    use TimestampableEntity;

    #[ORM\Column(type: Types::STRING, unique: false)]
    #[Groups(['social-accounts:full'])]
    private ?string $socialAccountId = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    #[Groups(['social-accounts:full'])]
    private ?bool $isVerified;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $username = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $avatarUrl = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['social-accounts:full'])]
    private ?string $socialAccountTypeAvatarUrl = null;

    #[ORM\Column(type: Types::STRING)]
    #[Groups(['social-accounts:full'])]
    private string $socialAccountType;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $email = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $givenName = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $familyName = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?int $followersCount = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?int $followingCount = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?int $likeCount = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?int $postCount = null;

    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'socialAccount', cascade: ['remove'])]
    private Collection $posts;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->isVerified = false;
        $this->posts = new ArrayCollection();
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): static
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocialAccountId(): ?string
    {
        return $this->socialAccountId;
    }

    public function setSocialAccountId(?string $socialAccountId): static
    {
        $this->socialAccountId = $socialAccountId;
        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(?bool $isVerified): static
    {
        $this->isVerified = $isVerified;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(?string $avatarUrl): static
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }
    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(?string $givenName): static
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(?string $familyName): static
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getSocialAccountType(): ?string
    {
        return $this->socialAccountType;
    }

    public function setSocialAccountType(string $socialAccountType): static
    {
        $this->socialAccountType = $socialAccountType;

        return $this;
    }

    public function getSocialAccountTypeAvatarUrl(): ?string
    {
        return $this->socialAccountTypeAvatarUrl;
    }

    public function setSocialAccountTypeAvatarUrl(string $socialAccountTypeAvatarUrl): static
    {
        $this->socialAccountTypeAvatarUrl = $socialAccountTypeAvatarUrl;

        return $this;
    }

    #[Groups(['social-accounts:full'])]
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    #[Groups(['social-accounts:full'])]
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setSocialAccount($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            if ($post->getSocialAccount() === $this) {
                $post->setSocialAccount(null);
            }
        }

        return $this;
    }

    public function getFollowersCount(): ?int
    {
        return $this->followersCount;
    }

    public function setFollowersCount(?int $followersCount): static
    {
        $this->followersCount = $followersCount;

        return $this;
    }

    public function getFollowingCount(): ?int
    {
        return $this->followingCount;
    }

    public function setFollowingCount(?int $followingCount): static
    {
        $this->followingCount = $followingCount;

        return $this;
    }

    public function getLikeCount(): ?int
    {
        return $this->likeCount;
    }

    public function setLikeCount(?int $likeCount): static
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    public function getPostCount(): ?int
    {
        return $this->postCount;
    }

    public function setPostCount(?int $postCount): static
    {
        $this->postCount = $postCount;

        return $this;
    }
}
