<?php

namespace App\ApiResource\Controller;

use App\Entity\User;
use App\Enum\PlatformType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class GetAnalysesPlatformsAction extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(#[CurrentUser] User $user): JsonResponse
    {
        $platforms = [
            [
                "id" => PlatformType::LINKEDIN->toString(),
                "icon" => "/images/ri_linkedin-fill.svg",
                "label" => ucfirst(PlatformType::LINKEDIN->toString()),
                "color" => "#0e76a8"
            ],
            [
                "id" => PlatformType::TWITTER->toString(),
                "icon" => "/images/ri_twitter-fill.svg",
                "label" => ucfirst(PlatformType::TWITTER->toString()),
                "color" => "#1da1f2"
            ],
            [
                "id" => PlatformType::FACEBOOK->toString(),
                "icon" => "/images/ri_facebook-fill.svg",
                "label" => ucfirst(PlatformType::FACEBOOK->toString()),
                "color" => "#4267B2"
            ],
            [
                "id" => PlatformType::YOUTUBE->toString(),
                "icon" => "/images/ri_youtube-fill.svg",
                "label" => ucfirst(PlatformType::YOUTUBE->toString()),
                "color" => "#FF0000"
            ],
            [
                "id" => PlatformType::INSTAGRAM->toString(),
                "icon" => "/images/ri_instagram-fill.svg",
                "label" => ucfirst(PlatformType::INSTAGRAM->toString()),
                "color" => "#E1306C"
            ],
        ];

        return new JsonResponse(
            data: $this->serializer->serialize($platforms, 'json'),
            status: Response::HTTP_OK,
            json: true
        );
    }
}