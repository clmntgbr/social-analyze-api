<?php

namespace App\Dto\Instagram;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class InstagramProfileData
{
    #[SerializedName('following_count')]
    public int $following;

    #[SerializedName('follower_count')]
    public int $follower;

    #[Assert\NotBlank]
    #[SerializedName('id')]
    public string $instagramId;

    public string $username;

    #[SerializedName('full_name')]
    public ?string $name;

    #[SerializedName('biography')]
    public ?string $biography;

    #[SerializedName('profile_pic_url_hd')]
    public ?string $profilePicture;

    #[SerializedName('public_email')]
    public ?string $email;

    #[SerializedName('is_verified')]
    public bool $isVerified = false;

    #[SerializedName('is_private')]
    public bool $isPrivate = false;

    #[SerializedName('category')]
    public ?string $category;
}