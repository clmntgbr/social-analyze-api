<?php

namespace App\Service\SocialAccount;

use App\Enum\PlatformType;
use App\Repository\AnalysisRepository;
use App\Repository\LinkedinPostRepository;
use App\Repository\SocialAccountRepository;
use App\Service\LinkedinRapidApi;
use Symfony\Component\Serializer\SerializerInterface;

readonly class SocialAccountFactory
{
    public function __construct(
        private LinkedinRapidApi    $linkedinRapidApi,
        private SerializerInterface $serializer,
        private AnalysisRepository $analysisRepository,
        private SocialAccountRepository $socialAccountRepository,
        private LinkedinPostRepository $linkedinPostRepository
    ){}

    public function getService(string $type): SocialAccountInterface
    {
        return match ($type) {
            PlatformType::LINKEDIN->toString() => new LinkedinSocialAccountService($this->linkedinRapidApi, $this->analysisRepository, $this->socialAccountRepository, $this->linkedinPostRepository, $this->serializer),
            PlatformType::FACEBOOK->toString() => new FacebookSocialAccountService(),
            PlatformType::TWITTER->toString() => new TwitterSocialAccountService(),
        };
    }
}