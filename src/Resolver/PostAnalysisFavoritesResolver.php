<?php

namespace App\Resolver;

use App\Dto\PostAnalysisFavorites;
use App\Service\ValidatorError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class PostAnalysisFavoritesResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface  $validator,
        private ValidatorError $validatorError
    ) {}

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== PostAnalysisFavorites::class) {
            return;
        }

        $content = $request->getContent();
        $postAnalysisFavorites = $this->serializer->deserialize($content, PostAnalysisFavorites::class, 'json');

        $errors = $this->validator->validate($postAnalysisFavorites);
        if (count($errors) > 0) {
            throw new BadRequestHttpException($this->validatorError->getMessageToString($errors));
        }

        yield $postAnalysisFavorites;
    }
}
