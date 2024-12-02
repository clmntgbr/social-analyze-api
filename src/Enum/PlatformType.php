<?php

namespace App\Enum;

enum PlatformType: string
{
    case FACEBOOK = "facebook";
    case TWITTER = "twitter";
    case LINKEDIN = "linkedin";
    case YOUTUBE = "youtube";
    case INSTAGRAM = "instagram";

    public function toString(): string
    {
        return $this->value;
    }
}
