<?php
require_once __DIR__ . '/vendor/autoload.php';
$config = require 'shippingRateCalc/config/configuration.php';

use App\Connection;
use App\FileCache;
use App\RecordSearch;
use GuzzleHttp\Client;

$client = new Client();
$recordSearch = new RecordSearch();
$cache = new FileCache($recordSearch, $config['catchPath']);
$connection = new Connection($cache, $client, $config);
echo '<pre>';

/** change getCache method argument to fetch different data from cache file.*/
$cacheData = $connection->getCache('name');

if (is_null($cacheData)) {
    echo 'cache time expired! Grabbing new data from printify server..' . PHP_EOL;
    $connection->saveCache(5);
} else {
    echo 'This data is read from cache file. ' . PHP_EOL.PHP_EOL;
    echo $cacheData . PHP_EOL;
}