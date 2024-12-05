<?php

namespace App\ApiResource\Controller;

use App\Dto\GetAnalysis;
use App\Entity\Analysis;
use App\Entity\User;
use App\Repository\AnalysisRepository;
use App\Service\AnalysisInsight;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[AsController]
class GetAnalysisInsightsAction extends AbstractController
{
    public function __construct(
        private readonly AnalysisRepository $analysisRepository,
        private readonly AnalysisInsight $analysisInsight
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

        $data['monthlyStats'] = $this->analysisInsight->calculateMonthlyStats($analysis->getSocialAccount());
        $data['hourlyStats'] = $this->analysisInsight->calculateHourlyStats($analysis->getSocialAccount());

        $postCount = $analysis->getSocialAccount()->getPostCount();

        $data['averageLikes'] = $postCount > 0
            ? round($analysis->getSocialAccount()->getLikeCount() / $postCount)
            : null;

        $data['averageComments'] = $postCount > 0
            ? round($analysis->getSocialAccount()->getCommentCount() / $postCount)
            : null;

        $data['averageReposts'] = $postCount > 0
            ? round($analysis->getSocialAccount()->getShareCount() / $postCount)
            : null;

        return new JsonResponse(
            data: $data,
            status: Response::HTTP_OK
        );
    }
}