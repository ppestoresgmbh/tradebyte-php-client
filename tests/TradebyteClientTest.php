<?php

namespace Tradebyte\Tests;

use PHPUnit\Framework\TestCase;
use Tradebyte\TradebyteClient;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use ReflectionClass;

class TradebyteClientTest extends TestCase
{
    public function testGetIncludingMerchantId()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['foo' => 'bar']))
        ]);
        $handler = HandlerStack::create($mock);
        $gClient = new Client(['handler' => $handler, 'base_uri' => 'https://api/']);
        $client = new TradebyteClient('MID123', 'https://api/', 'u','p');
        // override internal client for test
        $ref = new ReflectionClass($client);
        $prop = $ref->getProperty('client');
        $prop->setAccessible(true);
        $prop->setValue($client, $gClient);

        $res = $client->get('endpoint');
        $this->assertSame(['foo' => 'bar'], $res);
    }
}