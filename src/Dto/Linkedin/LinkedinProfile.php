<?php

namespace App\Dto\Linkedin;

use App\Dto\ProfileInterface;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class LinkedinProfile implements ProfileInterface
{
    #[SerializedName('connection')]
    public int $following;
    public int $follower;

    #[SerializedName("data")]
    public LinkedinProfileData $data;

    #[SerializedName("languages")]
    #[Assert\Valid]
    public ?array $posts = [];

    public function toArray(): array
    {
        return [
            'following' => $this->following,
            'follower' => $this->follower,
            'data' => $this->data->toArray(),
            'posts' => json_decode(json_encode($this->posts), true),
        ];
    }

    public function setPosts(?array $posts): self
    {
        $this->posts = array_map(function($data) {
            $post = new LinkedinProfilePost();
            $post->setPostId($data['urn']);
            $post->setAuthor($data['author']);
            $post->setArticle($data['article']);
            $post->setDocument($data['document']);
            $post->setPostAt(new \DateTime('@' . $data['postedDateTimestamp']/1000));
            $post->setUrl($data['postUrl'] ?? null);
            $post->setImages($data['image'] ?? []);
            $post->setBody($data['text'] ?? null);
            $post->setReposted($data['reposted'] ?? false);
            $post->setCommentsCount($data['commentsCount'] ?? null);
            $post->setRepostsCount($data['repostsCount'] ?? null);
            $post->setLikeCount($data['totalReactionCount'] ?? null);
            return $post;
        }, $posts ?? []);

        return $this;
    }
}