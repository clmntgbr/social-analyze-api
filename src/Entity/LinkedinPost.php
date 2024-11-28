<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\PostType;
use App\Repository\LinkedinPostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: LinkedinPostRepository::class)]
#[ApiResource()]
class LinkedinPost extends Post
{
    #[ORM\Column(type: Types::JSON)]
    #[Groups(['social-accounts:full'])]
    private array $article = [];

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['social-accounts:full'])]
    private array $document = [];

    public function __construct()
    {
        parent::__construct();
        $this->setPostType(PostType::LINKEDIN->toString());
    }

    public function getArticle(): array
    {
        return $this->article;
    }

    public function setArticle(array $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getDocument(): array
    {
        return $this->document;
    }

    public function setDocument(array $document): static
    {
        $this->document = $document;

        return $this;
    }
}
