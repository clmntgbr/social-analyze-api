<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
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
    'instagram_social_account' => 'InstagramSocialAccount',
    'youtube_social_account' => 'YoutubeSocialAccount',
])]
#[ApiResource(
    operations: [
        new GetCollection(),
    ]
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
    private ?string $firstName = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $profilePicture = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $backgroundImage = null;

    #[ORM\Column(type: Types::STRING)]
    #[Groups(['social-accounts:full'])]
    private string $socialAccountType;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $email = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?string $location = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?int $followerCount = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?int $followingCount = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?int $likeCount = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?int $commentCount = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?int $shareCount = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    #[Groups(['social-accounts:full'])]
    private ?float $engagementRate = null;

    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'socialAccount', cascade: ['remove'])]
    #[Groups(['social-accounts:full'])]
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

    #[Groups(['social-accounts:full'])]
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    #[Groups(['social-accounts:full'])]
    public function getTopPosts(int $limit = 6): array
    {
        $postsArray = $this->posts->toArray();

        usort($postsArray, function (Post $a, Post $b) {
            return $b->getEngagementRate() <=> $a->getEngagementRate();
        });

        return array_slice($postsArray, 0, $limit);
    }

    #[Groups(['social-accounts:full'])]
    public function getName(): string
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }

    #[Groups(['social-accounts:full'])]
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getSocialAccountId(): ?string
    {
        return $this->socialAccountId;
    }

    public function setSocialAccountId(string $socialAccountId): static
    {
        $this->socialAccountId = $socialAccountId;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFollowerCount(): ?int
    {
        return $this->followerCount;
    }

    public function setFollowerCount(?int $followerCount): static
    {
        $this->followerCount = $followerCount;

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

    #[Groups(['social-accounts:full'])]
    public function getPostCount(): ?int
    {
        return $this->posts->count();
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
            // set the owning side to null (unless already changed)
            if ($post->getSocialAccount() === $this) {
                $post->setSocialAccount(null);
            }
        }

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): static
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getBackgroundImage(): ?string
    {
        return $this->backgroundImage;
    }

    public function setBackgroundImage(?string $backgroundImage): static
    {
        $this->backgroundImage = $backgroundImage;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getCommentCount(): ?int
    {
        return $this->commentCount;
    }

    public function setCommentCount(?int $commentCount): static
    {
        $this->commentCount = $commentCount;

        return $this;
    }

    public function getShareCount(): ?int
    {
        return $this->shareCount;
    }

    public function setShareCount(?int $shareCount): static
    {
        $this->shareCount = $shareCount;

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
}
