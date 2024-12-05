<?php

namespace App\Service;

use App\Entity\Analysis;
use App\Repository\AnalysisRepository;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChatGPT
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private HttpClientInterface $httpClient,
        private readonly string $chatGptApiKey,
        private readonly string $chatGptApiUrl
    ) {}

    public function analyzeJson(Analysis $analysis): array
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups(['analyses:openAi'])
            ->toArray();

        $jsonData = $this->serializer->serialize($analysis, 'json', $context);
        $jsonArray = json_decode($jsonData, true);

        $prompt = $this->generatePromptFromData($jsonArray);
        $response = $this->callOpenAI($prompt);

        return $response;
    }

    private function generatePromptFromData(array $data): string
    {
        return "Analyse ces données JSON et donne des insights pertinents sur les comptes sociaux : " . json_encode($data);
    }

    private function callOpenAI(string $prompt): array
    {
        $response = $this->httpClient->request('POST', $this->chatGptApiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->chatGptApiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a data analyst.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ],
        ]);

        dd($response->toArray());
    }
}