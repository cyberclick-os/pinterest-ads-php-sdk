<?php

namespace PinterestAds\Http\Adapter;

use PinterestAds\Http\Client;

abstract class AbstractAdapter implements AdapterInterface
{

    protected Client $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function client(): Client {
        return $this->client;
    }

    public function caBundlePath(): string {
        return $this->client()->caBundlePath();
    }
}