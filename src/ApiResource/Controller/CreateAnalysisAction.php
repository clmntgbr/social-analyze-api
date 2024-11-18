<?php

namespace App\ApiResource\Controller;

use App\Dto\CreateAnalysis;
use App\Entity\User;
use App\Message\CreateAnalysisMessage;
use App\Repository\AnalysisRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class CreateAnalysisAction extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly AnalysisRepository $analysisRepository,
        private readonly UserRepository $userRepository
    ) {}

    public function __invoke(CreateAnalysis $postAnalyses, #[CurrentUser] User $user): JsonResponse
    {
        $analysis = $this->analysisRepository->updateOrCreate(
            [
                'username' => $postAnalyses->username,
                'platform' => $postAnalyses->platform,
            ],
            [
                'username' => $postAnalyses->username,
                'platform' => $postAnalyses->platform,
                'title' => sprintf('@%s', $postAnalyses->username),
            ]
        );

        $this->userRepository->update($user, ['analysis' => $analysis]);

        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups(['analyses:full', 'social-accounts:full'])
            ->toArray();

        return new JsonResponse(
            data: $this->serializer->serialize($analysis, 'json', $context),
            status: Response::HTTP_CREATED,
            json: true
        );
    }
}