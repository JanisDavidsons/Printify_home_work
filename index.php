<?php
require_once __DIR__ . '/vendor/autoload.php';
$config = require 'shippingRateCalc/config/configuration.php';

define('CACHE_TIME', 5);

use App\core\Connection;
use App\core\FileCache;
use App\core\RecordSearch;
use GuzzleHttp\Client;

$client = new Client();
$recordSearch = new RecordSearch();
$cache = new FileCache($recordSearch, $config['catchPath']);
$connection = new Connection($cache, $client, $config);

/**@todo For some reason base64 encoded API key wont authenticates in printify API server. */

/** change getCache method argument to fetch different data from cache file.*/
$cacheData = $connection->getCache('name');

echo '<pre>';

if (is_null($cacheData)) {
    echo 'cache time expired! Grabbing new data from printify server..' . PHP_EOL . PHP_EOL;
    echo $connection->saveCache(CACHE_TIME);
} else {
    echo 'This data is read from cache file. ' . PHP_EOL . PHP_EOL;
    echo $cacheData . PHP_EOL;
}