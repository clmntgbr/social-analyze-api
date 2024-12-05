<?php

namespace App\Dto\Instagram;

use Symfony\Component\Serializer\Annotation\SerializedName;

class InstagramPost
{
    #[SerializedName("data")]
    public InstagramPostData $data;

    #[SerializedName("pagination_token")]
    public ?string $paginationToken = null;
}
