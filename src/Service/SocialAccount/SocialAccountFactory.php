<?php

namespace App\Service\SocialAccount;

use App\Enum\PlatformType;
use App\Repository\AnalysisRepository;
use App\Repository\InstagramPostRepository;
use App\Repository\LinkedinPostRepository;
use App\Repository\SocialAccountRepository;
use App\Service\ImageService;
use App\Service\InstagramRapidApi;
use App\Service\LinkedinRapidApi;
use Symfony\Component\Serializer\SerializerInterface;

readonly class SocialAccountFactory
{
    public function __construct(
        private LinkedinRapidApi    $linkedinRapidApi,
        private InstagramRapidApi    $instagramRapidApi,
        private SerializerInterface $serializer,
        private AnalysisRepository $analysisRepository,
        private SocialAccountRepository $socialAccountRepository,
        private LinkedinPostRepository $linkedinPostRepository,
        private InstagramPostRepository $instagramPostRepository,
        private ImageService $imageService
    ){}

    public function getService(string $type): SocialAccountInterface
    {
        return match ($type) {
            PlatformType::LINKEDIN->toString() => new LinkedinSocialAccountService(
                $this->linkedinRapidApi,
                $this->analysisRepository,
                $this->socialAccountRepository,
                $this->linkedinPostRepository,
                $this->serializer
            ),
            PlatformType::FACEBOOK->toString() => new FacebookSocialAccountService(),
            PlatformType::TWITTER->toString() => new TwitterSocialAccountService(),
            PlatformType::YOUTUBE->toString() => new YoutubeSocialAccountService(),
            PlatformType::INSTAGRAM->toString() => new InstagramSocialAccountService(
                $this->instagramRapidApi,
                $this->serializer,
                $this->analysisRepository,
                $this->socialAccountRepository,
                $this->imageService,
                $this->instagramPostRepository
            ),
        };
    }
}