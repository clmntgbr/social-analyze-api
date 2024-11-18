<?php

namespace App\ApiResource\Controller;

use App\Dto\PostAnalyses;
use App\Entity\User;
use App\Repository\AnalysisRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class PostAnalysesAction extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly AnalysisRepository $analysisRepository,
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $em
    ) {}

    public function __invoke(PostAnalyses $postAnalyses, #[CurrentUser] User $user): JsonResponse
    {
        $analysis = $this->analysisRepository->updateOrCreate(
            [
                'username' => $postAnalyses->username,
                'platform' => $postAnalyses->platform,
            ],
            [
                'username' => $postAnalyses->username,
                'platform' => $postAnalyses->platform,
                'title' => sprintf('%s : %s', (new  \DateTime('now'))->format('d/m/Y'), $postAnalyses->username),
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