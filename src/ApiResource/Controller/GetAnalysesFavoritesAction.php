<?php

namespace App\ApiResource\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class GetAnalysesFavoritesAction extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(#[CurrentUser] User $user): JsonResponse
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups(['analyses:full', 'social-accounts:full'])
            ->toArray();

        return new JsonResponse(
            data: $this->serializer->serialize($user->getFavorites(), 'json', $context),
            status: Response::HTTP_OK,
            json: true
        );
    }
}