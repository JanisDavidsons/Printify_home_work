<?php
require_once __DIR__ . '/vendor/autoload.php';
$config = require 'shippingRateCalc/config/configuration.php';

use App\RecordSearch;
use App\ShippingRates;
use GuzzleHttp\Client;

$client = new Client();
$recordSearch = new RecordSearch();
$calculator = new ShippingRates($recordSearch, $config['catchPath']);

$clientHandler = $client->getConfig('handler');

$response = $client->request(
    'POST',
    'https://api.printful.com/shipping/rates',
    ['auth' => [$config['apiUserName'], $config['apiKey']], 'body' => json_encode($config['postBody'])]);

$rawData = json_decode($response->getBody(), true);

$calculator->set('shippingRates', $rawData, 5);
echo $calculator->get('maxDeliveryDays');