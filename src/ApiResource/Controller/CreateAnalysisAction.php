<?php

namespace App\ApiResource\Controller;

use App\Dto\CreateAnalysis;
use App\Entity\Analysis;
use App\Entity\User;
use App\Message\CreateAnalysisMessage;
use App\Repository\AnalysisRepository;
use App\Repository\UserRepository;
use App\Service\SocialAccount\SocialAccountFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class CreateAnalysisAction extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly AnalysisRepository $analysisRepository,
        private readonly UserRepository $userRepository,
        private readonly SocialAccountFactory $socialAccountFactory,
        private readonly MessageBusInterface $bus
    ) {}

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(CreateAnalysis $createAnalysis, #[CurrentUser] User $user): JsonResponse
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups(['analyses:full', 'social-accounts:full'])
            ->toArray();

        $analysis = $this->analysisRepository->findOneByCriteria([
            'username' => $createAnalysis->username,
            'platform' => $createAnalysis->platform,
        ]);

        if ($analysis instanceof Analysis) {
            return new JsonResponse(
                data: $this->serializer->serialize($analysis, 'json', $context),
                status: Response::HTTP_CREATED,
                json: true
            );
        }

        $service = $this->socialAccountFactory->getService($createAnalysis->platform);
        $payload = $service->getProfile($createAnalysis->username);

        if (!$payload['success']) {
            match ($payload['code']) {
                429 => $message = 'There was a problem with your request. Please try again later.',
                default => $message = 'This user profile doesn\'t exist.',
            };

            return new JsonResponse(
                data: $this->serializer->serialize(['message' => $message], 'json', $context),
                status: Response::HTTP_BAD_REQUEST,
                json: true
            );
        }

        $analysis = $this->analysisRepository->create([
            'username' => $createAnalysis->username,
            'platform' => $createAnalysis->platform,
            'title' => sprintf('@%s', $createAnalysis->username),
        ]);

        $this->userRepository->update($user, ['analysis' => $analysis]);

        $this->bus->dispatch(new CreateAnalysisMessage($createAnalysis->username, $createAnalysis->platform, $payload), [
            new AmqpStamp('high', AMQP_NOPARAM, []),
        ]);

        return new JsonResponse(
            data: $this->serializer->serialize($analysis, 'json', $context),
            status: Response::HTTP_CREATED,
            json: true
        );
    }
}