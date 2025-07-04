<?php

namespace Tradebyte;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

final class TradebyteClient
{
    private Client $client;
    public function __construct(
        private string $merchantId,
        string $baseUri,
        string $username,
        string $password,
    ) {
        $this->client = new Client([
            'base_uri' => rtrim($baseUri, '/') . '/',
            'auth' => [$username, $password],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-TB-Account' => $merchantId
            ]
        ]);
    }

    public function get(string $endpoint, array $query = []): array { return $this->request('GET', $endpoint, ['query' => $query]); }
    public function post(string $endpoint, array $data): array { return $this->request('POST', $endpoint, ['json' => $data]); }

    private function request(string $method, string $uri, array $options): array
    {
        try {
            $res = $this->client->request($method, $this->merchantId . '/' . ltrim($uri, '/'), $options);
            return json_decode($res->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
        } catch (RequestException $e) {
            throw new \RuntimeException("$method $uri failed: " . $e->getMessage());
        }
    }
}