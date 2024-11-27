<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class LinkedinRapidApi implements RapidApiInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string              $rapidApiKey,
        private string              $rapidApiLinkedinHost,
        private string              $rapidApiLinkedinUrl
    )
    {
    }

    public function isProfileExist(string $username): array
    {
        $response = $this->httpClient->request('GET', sprintf('%s%s?username=%s', $this->rapidApiLinkedinUrl, 'about-this-profile', $username), [
            'headers' => [
                'x-rapidapi-host' => $this->rapidApiLinkedinHost,
                'x-rapidapi-key' => $this->rapidApiKey,
            ],
        ]);

        return $response->toArray();
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
        try {
            $response = $this->httpClient->request('GET', sprintf('%s%s?username=%s', $this->rapidApiLinkedinUrl, 'profile-data-connection-count-posts', $username), [
                'headers' => [
                    'x-rapidapi-host' => $this->rapidApiLinkedinHost,
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

    public function getPosts(string $username)
    {
        // TODO: Implement getPosts() method.
    }

    public function mockGetProfile(string $username): array
    {
        try {
            $jsonString = file_get_contents("../src/Mock/$username.json");
        } catch (\Exception $exception) {
            return $this->mockGetProfileFail();
        }
        return json_decode($jsonString, true);
    }

    public function mockGetProfileFail(): array
    {
        $jsonString = file_get_contents('../src/Mock/fail.json');
        return json_decode($jsonString, true);
    }
}