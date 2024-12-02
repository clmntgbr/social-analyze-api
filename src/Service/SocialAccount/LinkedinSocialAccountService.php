<?php

namespace App\Service\SocialAccount;

use App\Dto\Linkedin\LinkedinProfile;
use App\Dto\Linkedin\LinkedinProfilePost;
use App\Entity\Analysis;
use App\Entity\LinkedinSocialAccount;
use App\Entity\SocialAccount;
use App\Enum\AnalysisStatus;
use App\Repository\AnalysisRepository;
use App\Repository\LinkedinPostRepository;
use App\Repository\SocialAccountRepository;
use App\Service\LinkedinRapidApi;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

readonly class LinkedinSocialAccountService implements SocialAccountInterface
{
    private const ENGAGEMENT_WEIGHTS = [
        'like' => 1,
        'comment' => 2,
        'repost' => 3,
    ];

    public function __construct(
        private LinkedinRapidApi     $linkedinRapidApi,
        private AnalysisRepository $analysisRepository,
        private SocialAccountRepository $socialAccountRepository,
        private LinkedinPostRepository $postRepository,
        private SerializerInterface $serializer
    ){}

    public function isProfileExist(string $username): bool
    {
        $response = $this->linkedinRapidApi->isProfileExist($username);

        if ($response['success'] === true) {
            return true;
        }

        return false;
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getProfile(string $username): ?array
    {
        return $this->linkedinRapidApi->getProfile($username);
    }

    public function hydrate(array $payload): void
    {
        /** @var LinkedinProfile $profile */
        $profile = $this->serializer->deserialize(json_encode($payload), LinkedinProfile::class, 'json');

        /** @var Analysis $analysis */
        $analysis = $this->analysisRepository->findOneByCriteria([
            'platform' => 'linkedin',
            'username' => $profile->data->username,
        ]);

        if ($analysis->getSocialAccount() === null) {
            $analysis->setSocialAccount(new LinkedinSocialAccount());
        }

        $socialAccount = $analysis->getSocialAccount();

        /** @var LinkedinSocialAccount $socialAccount */
        $socialAccount = $this->socialAccountRepository->update($socialAccount, [
            'socialAccountId' => $profile->data->linkedinId,
            'followerCount' => $profile->follower,
            'followingCount' => $profile->following,
            'isVerified' => false,
            'username' => $profile->data->username,
            'firstName' => ucwords(strtolower($profile->data->firstName)),
            'lastName' => ucwords(strtolower($profile->data->lastName)),
            'profilePicture' => $profile->data->profilePicture,
            'backgroundImage' => $profile->data->backgroundImageToString(),
            'isOpenToWork' => $profile->data->isOpenToWork,
            'isHiring' => $profile->data->isHiring,
            'summary' => $profile->data->summary,
            'headline' => $profile->data->headline,
            'location' => $profile->data->location,
            'skills' => $profile->data->skillsToArray(),
            'languages' => $profile->data->languagesToArray(),
            'educations' => $profile->data->educationsToArray(),
            'positions' => $profile->data->positionsToArray(),
            'payload' => $profile->toArray(),
        ]);

        $data = $this->createPosts($profile, $socialAccount);

        $this->socialAccountRepository->update($socialAccount, [
            'likeCount' => $data['like'],
            'shareCount' => $data['repost'],
            'commentCount' => $data['comment'],
            'engagementRate' => round($data['post'] > 0 ? $data['engagementRate'] / $data['post'] : 0, 2),
        ]);

        $this->analysisRepository->update($analysis, [
            'status' => AnalysisStatus::DONE->toString(),
        ]);
    }

    private function createPosts(LinkedinProfile $profile, SocialAccount $socialAccount): array
    {
        $calculate = [
            'like' => 0,
            'comment' => 0,
            'repost' => 0,
            'post' => 0,
            'engagementRate' => 0,
        ];

        /** @var LinkedinProfilePost $post */
        foreach ($profile->posts as $post) {
            if (!array_key_exists('username', $post->author)) {
                continue;
            }

            if ($post->author['username'] !== $socialAccount->getUsername() && $post->reposted) {
                continue;
            }

            if ($post->body === '') {
                continue;
            }

            $engagementRate = $this->calculateEngagementRate($post->commentsCount, $post->likeCount, $post->repostsCount, $socialAccount->getFollowerCount());

            $this->postRepository->create([
                'body' => $post->body,
                'postId' => $post->postId,
                'url' => $post->url,
                'images' => $post->images ?? [],
                'article' => $post->article ?? [],
                'document' => $post->document ?? [],
                'likeCount' => $post->likeCount ?? 0,
                'commentsCount' => $post->commentsCount ?? 0,
                'repostsCount' => $post->repostsCount ?? 0,
                'postAt' => $post->postAt,
                'socialAccount' => $socialAccount,
                'engagementRate' => $engagementRate,
            ]);

            $calculate['like'] += $post->likeCount ?? 0;
            $calculate['comment'] += $post->commentsCount ?? 0;
            $calculate['repost'] += $post->repostsCount ?? 0;
            $calculate['repost'] += $post->repostsCount ?? 0;
            $calculate['engagementRate'] += $engagementRate;
            $calculate['post']++;
        }

        return $calculate;
    }

    private function calculateEngagementRate(?float $likes = 0, ?float $comments = 0, ?float $reposts = 0, ?float $followers = 0): float
    {
        $likes = $likes ?? 0;
        $comments = $comments ?? 0;
        $reposts = $reposts ?? 0;
        $followers = $followers ?? 0;

        if ($followers <= 0) {
            return 0.0;
        }

        $weightedEngagement =
            ($likes * self::ENGAGEMENT_WEIGHTS['like']) +
            ($comments * self::ENGAGEMENT_WEIGHTS['comment']) +
            ($reposts * self::ENGAGEMENT_WEIGHTS['repost']);

        $engagementRate = ($weightedEngagement / $followers) * 100;
        return round($engagementRate, 2);
    }
}