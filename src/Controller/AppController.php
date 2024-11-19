<?php

namespace App\Controller;

use App\Repository\SocialAccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{
    #[Route('/api/status', name: 'status', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(['status' => 'OK']);
    }

    #[Route('/debug', name: 'debug', methods: ['GET'])]
    public function debug(SocialAccountRepository $socialAccountRepository)
    {
        $socialAccount = $socialAccountRepository->findBy(['uuid' => '4685edbd-ee16-4b25-ad8a-8fa727fe423e']);
        dd($socialAccount);
    }
}
