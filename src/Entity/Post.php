<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post as CreatePost;
use App\ApiResource\Controller\CreatePostsAction;
use App\ApiResource\Controller\GetPostAction;
use App\Entity\Traits\UuidTrait;
use App\Enum\PostGroupType;
use App\Enum\PostStatus;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
#[ApiFilter(SearchFilter::class, properties: ['status' => 'exact'])]
class Post
{
    use UuidTrait;
    use TimestampableEntity;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['posts:full', 'social-accounts:full'])]
    private ?string $postId = null;

    #[ORM\Column(type: Types::STRING)]
    #[Groups(['posts:create', 'posts:full', 'social-accounts:full'])]
    private ?string $groupType;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['posts:create', 'posts:full', 'social-accounts:full'])]
    private ?string $header = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['posts:create', 'posts:full'])]
    private ?string $body = null;

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['posts:create', 'posts:full', 'social-accounts:full'])]
    private array $pictures;

    #[ORM\Column(type: Types::STRING)]
    #[Groups(['posts:full', 'social-accounts:full'])]
    private string $status;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['posts:create', 'posts:full', 'social-accounts:full'])]
    private ?\DateTime $postAt = null;

    #[ORM\ManyToOne(targetEntity: SocialAccount::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['posts:full'])]
    private ?SocialAccount $socialAccount = null;

    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'children')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['posts:full'])]
    private ?Post $parent = null;

    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'parent')]
    #[ORM\OrderBy(['position' => 'ASC'])]
    #[Groups(['posts:full'])]
    private Collection $children;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->groupType = PostGroupType::CHILDREN->toString();
        $this->pictures = [];
        $this->status = PostStatus::DRAFT->toString();
        $this->children = new ArrayCollection();
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

    #[Groups(['posts:full'])]
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    #[Groups(['posts:full'])]
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getGroupType(): ?string
    {
        return $this->groupType;
    }

    public function setGroupType(string $groupType): static
    {
        $this->groupType = $groupType;

        return $this;
    }

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setHeader(?string $header): static
    {
        $this->header = $header;

        return $this;
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

    public function getPictures(): array
    {
        return $this->pictures;
    }

    public function setPictures(array $pictures): static
    {
        $this->pictures = $pictures;

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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Post $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Post $child): static
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }
}
