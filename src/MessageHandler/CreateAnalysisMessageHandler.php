<?php

namespace App\MessageHandler;

use App\Message\CreateAnalysisMessage;
use App\Service\SocialAccount\SocialAccountFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateAnalysisMessageHandler
{
    public function __construct(
        private SocialAccountFactory $socialAccountFactory,
        private LoggerInterface $logger
    ){}

    public function __invoke(CreateAnalysisMessage $message): void
    {
        $this->logger->info(sprintf('Create Analysis with username : %s', $message->getUsername()));

        $service = $this->socialAccountFactory->getService($message->getPlatform());
        $service->hydrate($message->getPayload());
    }
}
