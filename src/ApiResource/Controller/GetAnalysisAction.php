<?php

namespace App\ApiResource\Controller;

use App\Dto\GetAnalysis;
use App\Entity\User;
use App\Repository\AnalysisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class GetAnalysisAction extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly AnalysisRepository $analysisRepository
    ) {}

    public function __invoke(GetAnalysis $getAnalysis, #[CurrentUser] User $user): JsonResponse
    {
        $analysis = $this->analysisRepository->findOneByCriteria(['uuid' => $getAnalysis->uuid]);

        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups(['analyses:full', 'social-accounts:full'])
            ->toArray();

//        // Debug
//        $serializer = $this->serializer;
//        $reflectionMethod = new \ReflectionMethod($serializer, 'serialize');
//        $reflectionMethod->setAccessible(true);
//
//        $serializerDebug = fn($obj, $format, $context) => $reflectionMethod->invoke($serializer, $obj, $format, $context);
//
//        $debug = [
//            'object_class' => get_class($analysis->getSocialAccount()),
//            'reflection_properties' => array_map(fn($p) => $p->getName(), (new \ReflectionClass($analysis->getSocialAccount()))->getProperties()),
//            'groups' => $context['groups'],
//            'serialized_data' => json_decode($serializerDebug($analysis, 'json', $context), true)
//        ];
//
//        dd($debug);

        return new JsonResponse(
            data: $this->serializer->serialize($analysis, 'json', $context),
            status: Response::HTTP_OK,
            json: true
        );
    }
}