<?php

namespace App\core;

use App\interfaces\FileCacheInterface;
use GuzzleHttp\Client;

/**@todo Is this class ok to have? I made it to  inject FileCacheInterface somewhere..
 */

class Connection
{
    private FileCacheInterface $cache;
    private array $config;
    private Client $client;

    public function __construct(FileCacheInterface $cache, Client $client, array $config)
    {
        $this->cache = $cache;
        $this->config = $config;
        $this->client = $client;
    }

    public function getPostData(): array
    {
        $response = $this->client->request(
            'POST',
            'https://api.printful.com/shipping/rates',
            ['auth' => [$this->config['apiUserName'],
                $this->config['apiKey']],
                'body' => json_encode($this->config['postBody'])]);
        return json_decode($response->getBody(), true);
    }

    public function saveCache(int $duration): string
    {
        $cacheResult = null;
        foreach ($this->getPostData() as $key => $element) {
            global $cacheResult;
            $cacheResult = $this->cache->set($key, $element, $duration);
        }
        return $cacheResult;
    }

    public function getCache(string $recordKey): ?string
    {
        return $this->cache->get($recordKey);
    }
}