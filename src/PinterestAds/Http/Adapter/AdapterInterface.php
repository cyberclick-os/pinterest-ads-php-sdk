<?php

namespace PinterestAds\Http\Adapter;

use PinterestAds\Http\Client;
use PinterestAds\Http\RequestInterface;
use PinterestAds\Http\ResponseInterface;

interface AdapterInterface
{

    public function __construct(Client $client);

    public function client();

    public function caBundlePath(): string;

    public function opts(): array;

    public function setOpts(array $opts);

    public function sendRequest(RequestInterface $request): ResponseInterface;

}