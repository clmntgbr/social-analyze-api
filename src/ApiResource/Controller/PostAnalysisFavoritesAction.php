<?php

namespace App\ApiResource\Controller;

use App\Dto\PostAnalysisFavorites;
use App\Entity\Analysis;
use App\Entity\User;
use App\Repository\AnalysisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class PostAnalysisFavoritesAction extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly AnalysisRepository $analysisRepository,
        private readonly EntityManagerInterface $em
    ) {}

    public function __invoke(PostAnalysisFavorites $postAnalysisFavorites, #[CurrentUser] User $user): JsonResponse
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups(['analyses:full', 'social-accounts:full'])
            ->toArray();

        $analysis = $this->analysisRepository->findOneByCriteria(['uuid' => $postAnalysisFavorites->uuid]);

        if (!$analysis instanceof Analysis) {
            return new JsonResponse(
                data: $this->serializer->serialize(['message' => 'This analysis does not exist.'], 'json', $context),
                status: Response::HTTP_BAD_REQUEST,
                json: true
            );
        }

        if ($postAnalysisFavorites->status) {
            $user->addFavorite($analysis);
        }

        if (!$postAnalysisFavorites->status) {
            $user->removeFavorite($analysis);
        }

        $analysis->setIsFavorite($postAnalysisFavorites->status);

        $this->em->persist($user);
        $this->em->flush();

        return new JsonResponse(
            data: $this->serializer->serialize($analysis, 'json', $context),
            status: Response::HTTP_CREATED,
            json: true
        );
    }
}