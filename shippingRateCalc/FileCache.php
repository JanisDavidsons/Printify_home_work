<?php

namespace App;

use App\interfaces\FileCacheInterface;
use App\interfaces\RecordSearchInterface;

class FileCache implements FileCacheInterface
{
    private RecordSearchInterface $recordSearch;
    private string $cacheFilePath;

    public function __construct(RecordSearchInterface $recordSearch, string $cacheFilePath)
    {
        $this->recordSearch = $recordSearch;
        $this->cacheFilePath = $cacheFilePath;
    }

    public function set(string $key, $value, int $duration):string
    {
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
                $result = $this->recordSearch->findRecord($key, $data);
            }
            return $result;
        }
        return $result;
    }
}