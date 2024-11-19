<?php

namespace App\MessageHandler;

use App\Message\CreateAnalysisMessage;
use App\Service\SocialAccount\SocialAccountFactory;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateAnalysisMessageHandler
{
    public function __construct(
        private SocialAccountFactory $socialAccountFactory,
    ){}

    public function __invoke(CreateAnalysisMessage $message): void
    {
        $service = $this->socialAccountFactory->getService($message->getPlatform());
        $profile = $service->getProfile($message->getUsername());
        $service->hydrate($profile);
    }
}
