<?php
require __DIR__.'/../vendor/autoload.php';
use Tradebyte\TradebyteClient;

$client = new TradebyteClient('MID','https://rest.trade-server.net/rest/','user','pass');
$order = ['orderId'=>'123','items'=>[['sku'=>'A','qty'=>2]]];
print_r($client->post('orders?channel=123', $order));