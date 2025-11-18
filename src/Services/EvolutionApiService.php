<?php

declare(strict_types=1);

namespace Kalezao\EvolutionApi\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Kalezao\EvolutionApi\Contracts\EvolutionApiInterface;
use Kalezao\EvolutionApi\Exceptions\EvolutionApiException;

final class EvolutionApiService implements EvolutionApiInterface
{
    private Client $client;

    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiKey,
        private readonly int $timeout = 30
    ) {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
            'headers' => [
                'Content-Type' => 'application/json',
                'apikey' => $this->apiKey,
            ],
        ]);
    }

    public function sendText(string $instance, string $number, string $text, array $options = []): array
    {
        $payload = array_merge([
            'number' => $number,
            'text' => $text,
        ], $options);

        return $this->makeRequest('POST', "/message/sendText/{$instance}", $payload);
    }

    public function sendMedia(string $instance, string $number, string $mediaType, string $media, array $options = []): array
    {
        $payload = array_merge([
            'number' => $number,
            'mediatype' => $mediaType,
            'media' => $media,
        ], $options);

        return $this->makeRequest('POST', "/message/sendMedia/{$instance}", $payload);
    }

    public function sendStatus(string $instance, array $statusData): array
    {
        return $this->makeRequest('POST', "/message/sendStatus/{$instance}", $statusData);
    }

    public function createInstance(array $instanceData): array
    {
        return $this->makeRequest('POST', '/instance/create', $instanceData);
    }

    public function getInstance(string $instance): array
    {
        return $this->makeRequest('GET', "/instance/connect/{$instance}");
    }

    public function getQrCode(string $instance): array
    {
        return $this->makeRequest('GET', "/instance/connect/{$instance}");
    }

    public function disconnectInstance(string $instance): array
    {
        return $this->makeRequest('DELETE', "/instance/logout/{$instance}");
    }

    public function deleteInstance(string $instance): array
    {
        return $this->makeRequest('DELETE', "/instance/delete/{$instance}");
    }

    public function getInstances(): array
    {
        return $this->makeRequest('GET', '/instance/fetchInstances');
    }

    /**
     * Get all groups for an instance
     */
    public function getGroups(string $instance, bool $withParticipants = false): array
    {
        return $this->makeRequest(
            'GET',
            "/group/fetchAllGroups/{$instance}",
            [],
            ['getParticipants' => $withParticipants]
        );
    }

    private function makeRequest(string $method, string $endpoint, array $data = [], array $query = []): array
    {
        try {
            $options = [];

            if (! empty($data)) {
                $options['json'] = $data;
            }

            if (! empty($query)) {
                $options['query'] = $query;
            }

            $response = $this->client->request($method, $endpoint, $options);
            $body = $response->getBody()->getContents();

            return json_decode($body, true) ?? [];
        } catch (GuzzleException $e) {
            Log::error('Evolution API request failed', [
                'method' => $method,
                'endpoint' => $endpoint,
                'data' => $data,
                'error' => $e->getMessage(),
            ]);

            throw new EvolutionApiException(
                "Evolution API request failed: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }
}
