<?php
require __DIR__.'/../vendor/autoload.php';
use Tradebyte\TradebyteClient;

$client = new TradebyteClient('MID','https://rest.trade-server.net/rest/','user','pass');
$stock = ['articles'=>[['articleId'=>'A','stock'=>10]]];
print_r($client->post('articles/stock', $stock));