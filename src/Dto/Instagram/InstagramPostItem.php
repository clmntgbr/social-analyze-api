<?php

namespace App\Dto\Instagram;

use Symfony\Component\Serializer\Annotation\SerializedName;

class InstagramPostItem
{
    #[SerializedName("caption")]
    public InstagramPostCaption $caption;

    #[SerializedName("comment_count")]
    public ?int $commentCount = 0;

    #[SerializedName("id")]
    public string $id;

    #[SerializedName("ig_play_count")]
    public ?int $igPlayCount = 0;

    #[SerializedName("like_count")]
    public ?int $likeCount = 0;

    #[SerializedName("play_count")]
    public ?int $playCount = 0;

    #[SerializedName("share_count")]
    public ?int $shareCount = 0;

    #[SerializedName("taken_at")]
    public int $takenAt;

    #[SerializedName("taken_at_ts")]
    public int $takenAtTs;

    #[SerializedName("thumbnail_url")]
    public string $thumbnailUrl;

    #[SerializedName("thumbnail_url_original")]
    public string $thumbnailUrlOriginal;
}
