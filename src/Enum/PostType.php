<?php

namespace App\Enum;

enum PostType: string
{
    case FACEBOOK = "facebook_post";
    case TWITTER = "twitter_post";
    case LINKEDIN = "linkedin_post";

    public function toString(): string
    {
        return $this->value;
    }
}
