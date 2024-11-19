<?php

namespace App\Dto\Linkedin;

use App\Dto\ProfileInterface;
use Symfony\Component\Serializer\Attribute\SerializedName;

class LinkedinProfile implements ProfileInterface
{
    #[SerializedName('connection')]
    public int $following;
    public int $follower;

    #[SerializedName("data")]
    public LinkedinProfileData $data;

    public function toArray(): array
    {
        return [
            'following' => $this->following,
            'follower' => $this->follower,
            'data' => $this->data->toArray(),
        ];
    }
}