<?php

namespace App;

use App\interfaces\FileCacheInterface;
use App\interfaces\RecordSearchInterface;

class FileCache implements FileCacheInterface
{
    private RecordSearchInterface $recordSearch;
    private string $cacheFile;

    public function __construct(RecordSearchInterface $recordSearch, string $cacheFilePath)
    {
        $this->recordSearch = $recordSearch;
        $this->cacheFile = $cacheFilePath;
    }

    public function set(string $key, $value, int $duration): string
    {
        $currentCache = null;
        $jsonData = file_get_contents($this->cacheFile);
        if (!$jsonData) {
            $file = fopen($this->cacheFile, 'w');
            fwrite($file, json_encode([$key => $value]), JSON_UNESCAPED_UNICODE);
        } else {
            $cache = json_decode(file_get_contents($this->cacheFile), true);
            $cache[$key] = $value;

            $currentCache = json_encode($cache);
            $file = fopen($this->cacheFile, 'w');

            fwrite($file, $currentCache, JSON_UNESCAPED_UNICODE);
            fclose($file);
        }
        touch($this->cacheFile, time() + $duration * 60);
        return $currentCache;
    }

    public function get(string $key)
    {
        $jsonData = file_get_contents($this->cacheFile);
        $result = null;
        if ($jsonData) {
            if (filemtime($this->cacheFile) > time()) {
                $data = json_decode($jsonData, true);
                $result = $this->recordSearch->findRecord($key, $data);
            }
            return $result;
        }
        return $result;
    }
}