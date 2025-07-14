<?php

namespace Tradebyte;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

final class TradebyteClient
{
    private Client $client;
    public function __construct(
        string $baseUri,
        private string $merchantId,
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

    public function get(string $endpoint, array $query = []) { return $this->request('GET', $endpoint, ['query' => $query]); }
    public function post(string $endpoint, array $data) { return $this->request('POST', $endpoint, ['json' => $data]); }

    private function request(string $method, string $uri, array $options)
    {
        try {
            $res = $this->client->request($method, $this->merchantId . '/' . ltrim($uri, '/'), $options);

            $body = $res->getBody();
            $contents = $body->getContents();
            $body->rewind();

            $xml = simplexml_load_string($contents);

            if ($xml === false) {
                return $contents;
            }

            return $xml;
        } catch (RequestException $e) {
            throw new \RuntimeException("$method $uri failed: " . $e->getMessage());
        }
    }
}