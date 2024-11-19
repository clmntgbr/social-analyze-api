<?php

namespace App\Resolver;

use App\Dto\GetAnalysis;
use App\Service\ValidatorError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class GetAnalysisResolver implements ValueResolverInterface
{
    public function __construct(
        private ValidatorInterface  $validator,
        private ValidatorError $validatorError
    ) {}

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== GetAnalysis::class) {
            return;
        }

        $getAnalysis = new GetAnalysis();
        $getAnalysis->uuid = $request->attributes->get('uuid', null);

        $errors = $this->validator->validate($getAnalysis);
        if (count($errors) > 0) {
            throw new BadRequestHttpException($this->validatorError->getMessageToString($errors));
        }

        yield $getAnalysis;
    }
}
