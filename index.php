<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\ShippingRateCalc;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;

$client = new Client();
$calculator = new ShippingRateCalc();

$clientHandler = $client->getConfig('handler');
$tapMiddleware = Middleware::tap(function ($request) {
    $request->getBody();
});

$response = $client->request(
    'POST',
    'https://api.printful.com/shipping/rates',
    ['auth' => ['', '77qn9aax-qrrm-idki:lnh0-fm2nhmp0yca7'],
        'body' => json_encode(
            ['recipient' => [
                'address1' => '11025 Westlake Dr',
                'city' => 'Charlotte',
                'country_code' => 'US',
                "state_code" => "NC",
                "zip" => 28273
            ], 'items' => [[
                'quantity' => 2,
                "variant_id" => 7679
            ]]]),
        'handler' => $tapMiddleware($clientHandler)]);

$rawData = json_decode($response->getBody(), true);

//$calculator->set('shippingRates', $rawData, 5);
echo $calculator->get('maxDeliveryDays');