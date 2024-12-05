<?php

namespace App\Dto\Instagram;

use Symfony\Component\Serializer\Annotation\SerializedName;

class InstagramPostCaption
{
    #[SerializedName("created_at")]
    public int $createdAt;

    #[SerializedName("created_at_utc")]
    public int $createdAtUtc;

    #[SerializedName("hashtags")]
    /** @var string[] */
    public array $hashtags;

    #[SerializedName("id")]
    public string $id;

    #[SerializedName("text")]
    public string $text;

    #[SerializedName("text_translation")]
    public string $textTranslation;
}
