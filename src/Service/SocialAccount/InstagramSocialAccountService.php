<?php

namespace App\Service\SocialAccount;

use App\Dto\Instagram\InstagramPost;
use App\Dto\Instagram\InstagramProfile;
use App\Dto\Linkedin\LinkedinProfile;
use App\Entity\Analysis;
use App\Entity\InstagramSocialAccount;
use App\Entity\LinkedinSocialAccount;
use App\Enum\AnalysisStatus;
use App\Repository\AnalysisRepository;
use App\Repository\InstagramPostRepository;
use App\Repository\LinkedinPostRepository;
use App\Repository\SocialAccountRepository;
use App\Service\ImageService;
use App\Service\InstagramRapidApi;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

readonly class InstagramSocialAccountService implements SocialAccountInterface
{
    const MAX_ITERATIONS = 3;
    const ENGAGEMENT_WEIGHTS = [
        'like' => 1,
        'comment' => 2,
        'repost' => 3,
        'play' => 4,
    ];

    public function __construct(
        private InstagramRapidApi       $instagramRapidApi,
        private SerializerInterface     $serializer,
        private AnalysisRepository      $analysisRepository,
        private SocialAccountRepository $socialAccountRepository,
        private ImageService            $imageService,
        private InstagramPostRepository $postRepository
    )
    {
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getProfile(string $username): ?array
    {
        return $this->instagramRapidApi->mockGetProfile($username);
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function hydrate(array $payload): void
    {
        /** @var InstagramProfile $profile */
        $profile = $this->serializer->deserialize(json_encode($payload), InstagramProfile::class, 'json');

        /** @var Analysis $analysis */
        $analysis = $this->analysisRepository->findOneByCriteria([
            'platform' => 'instagram',
            'username' => $profile->data->username,
        ]);

        if ($analysis->getSocialAccount() === null) {
            $analysis->setSocialAccount(new InstagramSocialAccount());
        }

        $socialAccount = $analysis->getSocialAccount();

        /** @var InstagramSocialAccount $socialAccount */
        $socialAccount = $this->socialAccountRepository->update($socialAccount, [
            'socialAccountId' => $profile->data->instagramId,
            'followerCount' => $profile->data->follower,
            'followingCount' => $profile->data->following,
            'username' => $profile->data->username,
            'name' => $profile->data->name,
            'profilePicture' => $this->imageService->download(
                    $profile->data->profilePicture,
                    sprintf('images/%s/%s', 'instagram', $profile->data->instagramId)
                ),
            'email' => $profile->data->email,
            'isVerified' => $profile->data->isVerified,
            'headline' => $profile->data->biography,
            'isPrivate' => $profile->data->isPrivate,
            'category' => $profile->data->category,
        ]);

        $data = $this->createPosts($socialAccount);

        $this->socialAccountRepository->update($socialAccount, [
            'likeCount' => $data['like'],
            'shareCount' => $data['repost'],
            'commentCount' => $data['comment'],
            'playCount' => $data['play'],
            'engagementRate' => round($data['post'] > 0 ? $data['engagementRate'] / $data['post'] : 0, 2),
        ]);

        $this->analysisRepository->update($analysis, [
            'status' => AnalysisStatus::DONE->toString(),
        ]);
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function createPosts(InstagramSocialAccount $socialAccount): array
    {
        $calculate = ['like' => 0, 'comment' => 0, 'repost' => 0, 'post' => 0, 'play' => 0, 'engagementRate' => 0];
        $paginationToken = null;

        for ($i = 0; $i <= self::MAX_ITERATIONS; ++$i) {
            $response = $this->instagramRapidApi->mockGetPosts($socialAccount->getUsername(), $paginationToken, $i + 1);

            if (!$response['success']) {
                continue;
            }

            /** @var InstagramPost $posts */
            $posts = $this->serializer->deserialize(json_encode($response), InstagramPost::class, 'json');

            foreach ($posts->data->items as $postData) {
                $engagementRate = $this->calculateEngagementRate($postData->commentCount, $postData->likeCount, $postData->shareCount, $postData->playCount, $socialAccount->getFollowerCount());
                $dateTime = new \DateTime();

                $this->postRepository->create([
                    'body' => $postData->caption->text,
                    'postId' => $postData->id,
                    'likeCount' => $postData->likeCount ?? 0,
                    'commentsCount' => $postData->commentCount ?? 0,
                    'repostsCount' => $postData->shareCount ?? 0,
                    'playCount' => $postData->playCount ?? 0,
                    'postAt' => $dateTime->setTimestamp($postData->takenAtTs),
                    'socialAccount' => $socialAccount,
                    'engagementRate' => $engagementRate,
                ]);

                $calculate['like'] += $postData->likeCount ?? 0;
                $calculate['comment'] += $postData->commentCount ?? 0;
                $calculate['repost'] += $postData->shareCount ?? 0;
                $calculate['play'] += $postData->playCount ?? 0;
                $calculate['engagementRate'] += $engagementRate;
                $calculate['post']++;
            }

            $paginationToken = $posts->paginationToken;
        }

        return $calculate;
    }

    private function calculateEngagementRate(?float $likes = 0, ?float $comments = 0, ?float $reposts = 0, ?float $play = 0, ?float $followers = 0): float
    {
        $likes = $likes ?? 0;
        $comments = $comments ?? 0;
        $reposts = $reposts ?? 0;
        $play = $play ?? 0;
        $followers = $followers ?? 0;

        if ($followers <= 0) {
            return 0.0;
        }

        $weightedEngagement =
            ($likes * self::ENGAGEMENT_WEIGHTS['like']) +
            ($comments * self::ENGAGEMENT_WEIGHTS['comment']) +
            ($reposts * self::ENGAGEMENT_WEIGHTS['repost']) +
            ($play * self::ENGAGEMENT_WEIGHTS['play']);

        $engagementRate = ($weightedEngagement / $followers) * 100;
        return round($engagementRate, 2);
    }
}