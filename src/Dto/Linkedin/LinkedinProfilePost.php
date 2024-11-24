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

    #[SerializedName("image")]
    public ?array $images = [];

    #[SerializedName("totalReactionCount")]
    public ?int $likeCount = 0;

    public ?int $commentsCount = 0;
    public ?int $repostsCount = 0;
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

    public function setImages(array $images): LinkedinProfilePost
    {
        $this->images = $images;
        return $this;
    }
}