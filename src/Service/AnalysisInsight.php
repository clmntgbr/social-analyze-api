<?php

namespace App\Service;

use App\Entity\SocialAccount;

readonly class AnalysisInsight
{
    public function __construct()
    {
    }

    public function calculateMonthlyStats(SocialAccount $socialAccount): array
    {
        $posts = $socialAccount->getPosts();
        $stats = [];

        $endDate = new \DateTime();
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = (clone $endDate)->modify("-$i months")->modify('first day of this month')->setTime(0, 0, 0);
            $monthEnd = (clone $monthStart)->modify('last day of this month')->setTime(23, 59, 59);

            $monthlyPosts = $posts->filter(function($post) use ($monthStart, $monthEnd) {
                return $post->getPostAt() >= $monthStart && $post->getPostAt() <= $monthEnd;
            });

            $stats[] = [
                'month' => $monthStart->format('m'),
                'label' => sprintf('%s %s', $monthStart->format('F'), $monthStart->format('Y')),
                'year' => $monthStart->format('Y'),
                'posts' => $monthlyPosts->count(),
                'likes' => array_sum($monthlyPosts->map(fn($p) => $p->getLikeCount())->toArray()),
                'comments' => array_sum($monthlyPosts->map(fn($p) => $p->getCommentsCount())->toArray()),
                'reposts' => array_sum($monthlyPosts->map(fn($p) => $p->getRepostsCount())->toArray()),
                'engagementRate' => $monthlyPosts->count() > 0
                    ? round($monthlyPosts->map(fn($p) => $p->getEngagementRate())->reduce(fn($carry, $rate) => $carry + $rate, 0) / $monthlyPosts->count(), 2)
                    : 0
            ];
        }

        return $stats;
    }

    public function calculateHourlyStats(SocialAccount $socialAccount): array
    {
        $posts = $socialAccount->getPosts();
        $dataByHour = [];

        foreach ($posts as $post) {
            $postHour = $post->getPostAt()->format('H');
            $nextHour = str_pad(($postHour + 1) % 24, 2, '0', STR_PAD_LEFT);
            $hourRange = $postHour . 'h-' . $nextHour . 'h';

            if (!isset($dataByHour[$hourRange])) {
                $dataByHour[$hourRange] = [
                    'likes' => 0,
                    'comments' => 0,
                    'reposts' => 0,
                    'totalEngagementRate' => 0,
                    'count' => 0,
                ];
            }

            $dataByHour[$hourRange]['likes'] += $post->getLikeCount();
            $dataByHour[$hourRange]['comments'] += $post->getCommentsCount();
            $dataByHour[$hourRange]['reposts'] += $post->getRepostsCount();
            $dataByHour[$hourRange]['totalEngagementRate'] += $post->getEngagementRate();
            $dataByHour[$hourRange]['count']++;
        }

        foreach ($dataByHour as $hour => &$data) {
            $data['engagementRate'] = round($data['totalEngagementRate'] / $data['count'], 2);
            unset($data['totalEngagementRate']);
            unset($data['count']);
        }

        return $dataByHour;
    }
}