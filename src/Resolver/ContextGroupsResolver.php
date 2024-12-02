<?php

namespace App\Resolver;

use App\Dto\ContextGroups;
use App\Entity\FacebookPost;
use App\Entity\FacebookSocialAccount;
use App\Entity\InstagramPost;
use App\Entity\InstagramSocialAccount;
use App\Entity\LinkedinPost;
use App\Entity\LinkedinSocialAccount;
use App\Entity\Post;
use App\Entity\SocialAccount;
use App\Entity\TwitterPost;
use App\Entity\TwitterSocialAccount;
use App\Entity\User;
use App\Entity\YoutubePost;
use App\Entity\YoutubeSocialAccount;
use App\Service\ContextService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ContextGroupsResolver implements ValueResolverInterface
{
    private array $allowedEntity = [
        SocialAccount::class,
        FacebookSocialAccount::class,
        YoutubeSocialAccount::class,
        InstagramSocialAccount::class,
        LinkedinSocialAccount::class,
        TwitterSocialAccount::class,
        Post::class,
        YoutubePost::class,
        InstagramPost::class,
        LinkedinPost::class,
        FacebookPost::class,
        TwitterPost::class,
        User::class,
    ];

    public function __construct(
        private readonly ContextService $contextService
    ) {}

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== ContextGroups::class) {
            return;
        }

        $contextGroups = new ContextGroups();
        $contextGroups->groups = null;

        if (in_array($request->attributes->get('_api_resource_class'), $this->allowedEntity)) {
            $data = $request->query->get('groups', '');
            $groups = $this->contextService->getGroups($data);
            $contextGroups->groups = $groups;
        }

        yield $contextGroups;
    }
}
