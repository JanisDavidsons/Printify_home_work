<?php

namespace App;

use App\interfaces\FileCacheInterface;
use GuzzleHttp\Client;

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

    public function saveCache(int $duration): void
    {
        foreach ($this->getPostData() as $key => $element) {
            $this->cache->set($key, $element, $duration);
        }
    }

    public function getCache(string $recordKey): ?string
    {
        return $this->cache->get($recordKey);
    }
}