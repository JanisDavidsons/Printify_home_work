<?php
require_once __DIR__ . '/vendor/autoload.php';
$config = require 'shippingRateCalc/config/configuration.php';

use App\RecordSearch;
use App\FileCache;
use App\Connection;
use GuzzleHttp\Client;

$client = new Client();
$recordSearch = new RecordSearch();
$cache = new FileCache($recordSearch, $config['catchPath']);
$connection = new Connection($cache,$client,$config);

$connection->saveCache('shippingRates',5);

echo '<pre>';
echo $connection->getCache('shippingRates');