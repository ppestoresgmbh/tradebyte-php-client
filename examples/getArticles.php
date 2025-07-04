<?php
require __DIR__.'/../vendor/autoload.php';
use Tradebyte\TradebyteClient;

$client = new TradebyteClient('MID', 'https://rest.trade-server.net/rest/', 'user', 'pass');
print_r($client->get('products?channel=123'));