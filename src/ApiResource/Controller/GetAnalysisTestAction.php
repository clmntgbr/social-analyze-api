<?php

namespace App\ApiResource\Controller;

use App\Dto\GetAnalysis;
use App\Entity\Analysis;
use App\Entity\User;
use App\Repository\AnalysisRepository;
use App\Service\ChatGPT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class GetAnalysisTestAction extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly AnalysisRepository $analysisRepository,
        private readonly ChatGPT $chatGPT
    ) {}

    public function __invoke(GetAnalysis $getAnalysis, #[CurrentUser] User $user): JsonResponse
    {
        $analysis = $this->analysisRepository->findOneByCriteria(['uuid' => $getAnalysis->uuid]);

        if (!$analysis instanceof Analysis || !$analysis->getSocialAccount()) {
            return new JsonResponse(
                data: [],
                status: Response::HTTP_OK
            );
        }

        $this->chatGPT->analyzeJson($analysis);

        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups(['analyses:openAi'])
            ->toArray();

        return new JsonResponse(
            data: $this->serializer->serialize($analysis, 'json', $context),
            status: Response::HTTP_OK,
            json: true
        );
    }
}