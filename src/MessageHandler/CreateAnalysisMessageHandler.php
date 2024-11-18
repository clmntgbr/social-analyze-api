<?php

namespace App\MessageHandler;

use App\Message\CreateAnalysisMessage;
use App\Repository\AnalysisRepository;
use App\Service\LinkedinRapidApi;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateAnalysisMessageHandler
{
    public function __construct(
        private readonly LinkedinRapidApi $linkedinRapidApi,
    ){}

    public function __invoke(CreateAnalysisMessage $message): void
    {
        $this->linkedinRapidApi->getProfile($message->getUsername());
        dd($message);
    }
}
