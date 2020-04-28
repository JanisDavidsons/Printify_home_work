<?php

namespace App;

use App\interfaces\ShippingRateInterface;


class ShippingRateCalc implements ShippingRateInterface
{
    private const CACHE_FILE = './shippingRateCalc/cache/cache.json';

    public function set(string $key, $value, int $duration)
    {
//        $fp = fopen(self::CACHE_FILE, 'w');
//        fputcsv($fp, [$key, $value]);
//        return json_encode([$key => $value]);

//        $jsonData = file_get_contents(self::CACHE_FILE);
//        $shippingRates = json_decode($jsonData,true);
//        var_dump($shippingRates);
        //$data[$key]=$value;

        $file = fopen(self::CACHE_FILE, 'w');

        fwrite($file, json_encode([$key => $value], JSON_UNESCAPED_UNICODE));
        touch(self::CACHE_FILE, time() + $duration * 60);
        fclose($file);
        return json_encode([$key => $value]);
    }

    public function get(string $key)
    {
        $jsonData = file_get_contents(self::CACHE_FILE);
        $result = null;

        if ($jsonData) {
            if (filemtime(self::CACHE_FILE) > time()) {
                $data = json_decode($jsonData, true);
                $result = RecordSearch::findRecord($key,$data);
//                var_dump($data);
//                    $result = json_encode($data);
//                }
            }
            return $result;
        }
        //var_dump($result);
        return $result;
    }
}