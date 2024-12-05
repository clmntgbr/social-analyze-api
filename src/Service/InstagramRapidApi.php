<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class InstagramRapidApi implements RapidApiInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private LoggerInterface     $logger,
        private string              $projectRoot,
        private string              $rapidApiKey,
        private string              $rapidApiInstagramHost,
        private string              $rapidApiInstagramUrl
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getProfile(string $username): array
    {
        $this->logger->info("Instagram GetProfile Api call with username $username");
        try {
            $response = $this->httpClient->request('GET', sprintf('%s%sinfo?username_or_id_or_url=%s&url_embed_safe=true', $this->rapidApiInstagramUrl, 'v1/', $username), [
                'headers' => [
                    'x-rapidapi-host' => $this->rapidApiInstagramHost,
                    'x-rapidapi-key' => $this->rapidApiKey,
                ],
            ]);

            if ($response->getStatusCode() === 200 && !array_key_exists('success', $response->toArray())) {
                return array_merge(['success' => true], $response->toArray());
            }

            return array_merge(['code' => 404, 'success' => false], $response->toArray());
        } catch (ClientExceptionInterface $e) {
            return [
                'success' => false,
                'code' => $e->getCode(),
            ];
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getPosts(string $username, ?string $paginationToken): array
    {
        $this->logger->info("Instagram GetPosts Api call with username $username");
        $url = sprintf('%s%sposts?username_or_id_or_url=%s&url_embed_safe=true', $this->rapidApiInstagramUrl, 'v1.2/', $username);

        if ($paginationToken) {
            $url .= '&pagination_token=' . $paginationToken;
        }

        try {
            $response = $this->httpClient->request('GET', $url, [
                'headers' => [
                    'x-rapidapi-host' => $this->rapidApiInstagramHost,
                    'x-rapidapi-key' => $this->rapidApiKey,
                ],
            ]);

            if ($response->getStatusCode() === 200 && !array_key_exists('success', $response->toArray())) {
                return array_merge(['success' => true], $response->toArray());
            }

            return array_merge(['code' => 404, 'success' => false], $response->toArray());
        } catch (ClientExceptionInterface $e) {
            return [
                'success' => false,
                'code' => $e->getCode(),
            ];
        }
    }

    public function mockGetProfile(string $username): array
    {
        $this->logger->debug("[Mocking] Instagram GetProfile Api call with username $username");
        try {
            $jsonString = file_get_contents("$this->projectRoot/src/Mock/instagram/$username.json");
        } catch (\Exception $exception) {
            return $this->mockGetProfileFail();
        }
        return json_decode($jsonString, true);
    }

    public function mockGetPosts(string $username, ?string $paginationToken, int $index = 1): array
    {
        $this->logger->debug("[Mocking] Instagram GetPosts Api call with username $username");
        try {
            $jsonString = file_get_contents("$this->projectRoot/src/Mock/instagram/post/$username-$index.json");
        } catch (\Exception $exception) {
            return ['code' => 404, 'success' => false];
        }
        return json_decode($jsonString, true);
    }

    public function mockGetProfileFail(): array
    {
        $jsonString = file_get_contents("$this->projectRoot/src/Mock/instagram/fail.json");
        return json_decode($jsonString, true);
    }
}