<?php

namespace App\Dto\Instagram;

use App\Dto\ProfileInterface;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class InstagramProfile implements ProfileInterface
{
    #[SerializedName("data")]
    public InstagramProfileData $data;
}