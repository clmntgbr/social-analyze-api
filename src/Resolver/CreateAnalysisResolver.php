<?php

namespace App\Resolver;

use App\Dto\CreateAnalysis;
use App\Service\ValidatorError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateAnalysisResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface  $validator,
        private ValidatorError $validatorError
    ) {}

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== CreateAnalysis::class) {
            return;
        }

        $content = $request->getContent();
        $createAnalysis = $this->serializer->deserialize($content, CreateAnalysis::class, 'json');

        $errors = $this->validator->validate($createAnalysis);
        if (count($errors) > 0) {
            throw new BadRequestHttpException($this->validatorError->getMessageToString($errors));
        }

        yield $createAnalysis;
    }
}
