<?php

namespace App\Dto\Instagram;

use Symfony\Component\Serializer\Annotation\SerializedName;

class InstagramPostData
{
    #[SerializedName("count")]
    public int $count;

    #[SerializedName("items")]
    /** @var InstagramPostItem[] $items */
    public array $items;
}
