<?php

namespace App\Dto\Linkedin;

use Symfony\Component\Serializer\Attribute\SerializedName;

class LinkedinProfilePost
{
    #[SerializedName("urn")]
    public ?string $postId = null;

    #[SerializedName("text")]
    public ?string $body = null;

    public array $author = [];
    public array $article = [];
    public array $document = [];

    #[SerializedName("image")]
    public ?array $images = [];

    #[SerializedName("totalReactionCount")]
    public ?int $likeCount = 0;

    public ?int $commentsCount = 0;
    public ?int $repostsCount = 0;
    public bool $reposted = false;
    public ?\DateTime $postAt = null;

    #[SerializedName("postUrl")]
    public ?string $url = null;

    public function toArray(): array
    {
        return [
            'body' => $this->body,
            'postId' => $this->postId,
            'likeCount' => $this->likeCount,
            'commentsCount' => $this->commentsCount,
            'reposted' => $this->reposted,
            'repostsCount' => $this->repostsCount,
            'postAt' => $this->postAt,
        ];
    }

    public function setPostId(?string $postId): LinkedinProfilePost
    {
        $this->postId = $postId;
        return $this;
    }

    public function setAuthor(?array $author): LinkedinProfilePost
    {
        $this->author = $author ?? [];
        return $this;
    }

    public function setBody(?string $body): LinkedinProfilePost
    {
        $this->body = $body;
        return $this;
    }

    public function setLikeCount(?int $likeCount): LinkedinProfilePost
    {
        $this->likeCount = $likeCount;
        return $this;
    }

    public function setCommentsCount(?int $commentsCount): LinkedinProfilePost
    {
        $this->commentsCount = $commentsCount;
        return $this;
    }

    public function setRepostsCount(?int $repostsCount): LinkedinProfilePost
    {
        $this->repostsCount = $repostsCount;
        return $this;
    }

    public function setReposted(?bool $reposted): LinkedinProfilePost
    {
        $this->reposted = $reposted ?? false;
        return $this;
    }

    public function setPostAt(?\DateTime $postAt): LinkedinProfilePost
    {
        $this->postAt = $postAt;
        return $this;
    }

    public function setUrl(?string $url): LinkedinProfilePost
    {
        $this->url = $url;
        return $this;
    }

    public function setArticle(?array $article): LinkedinProfilePost
    {
        $this->article = $article;
        return $this;
    }

    public function setDocument(?array $document): LinkedinProfilePost
    {
        if (!$document) {
            return $this;
        }

        $this->document = [
            'url' => $document['TranscribedDocumentUrl'],
            'title' => $document['title'],
            'totalPageCount' => $document['totalPageCount'],
        ];

        return $this;
    }

    public function setImages(array $images): LinkedinProfilePost
    {
        $this->images = $images;
        return $this;
    }
}