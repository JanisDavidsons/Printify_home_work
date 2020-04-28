<?php

namespace App;

use App\interfaces\RecordSearchInterface;
use App\interfaces\ShippingRateInterface;

class ShippingRates implements ShippingRateInterface
{
    private RecordSearchInterface $recordSearch;
    private string $cacheFilePath;

    public function __construct(RecordSearchInterface $recordSearch,string $cacheFilePath)
    {
        $this->recordSearch = $recordSearch;
        $this->cacheFilePath = $cacheFilePath;
    }

    public function set(string $key, $value, int $duration)
    {
//        $fp = fopen(self::CACHE_FILE, 'w');
//        fputcsv($fp, [$key, $value]);
//        return json_encode([$key => $value]);

//        $jsonData = file_get_contents(self::CACHE_FILE);
//        $shippingRates = json_decode($jsonData,true);
//        var_dump($shippingRates);
        //$data[$key]=$value;

        $file = fopen($this->cacheFilePath, 'w');

        fwrite($file, json_encode([$key => $value], JSON_UNESCAPED_UNICODE));
        touch($this->cacheFilePath, time() + $duration * 60);
        fclose($file);
        return json_encode([$key => $value]);
    }

    public function get(string $key)
    {
        $jsonData = file_get_contents($this->cacheFilePath);
        $result = null;

        if ($jsonData) {
            if (filemtime($this->cacheFilePath) > time()) {
                $data = json_decode($jsonData, true);
                $result = RecordSearch::findRecord($key,$data);
            }
            return $result;
        }
        //var_dump($result);
        return $result;
    }
}