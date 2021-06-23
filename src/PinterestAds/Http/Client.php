<?php

namespace PinterestAds\Http;

use PinterestAds\ApiConfig;
use PinterestAds\Http\Adapter\AdapterInterface;
use PinterestAds\Http\Adapter\CurlAdapter;

class Client
{
    const DEFAULT_BASE_DOMAIN = 'pinterest.com/ads';
    const DEFAULT_LAST_LEVEL_DOMAIN = 'api';
    protected ?RequestInterface $requestPrototype = null;
    protected ResponseInterface $responsePrototype;
    protected Headers $defaultRequestHeaders;
    protected ?AdapterInterface $adapter = null;
    protected string $caBundlePath;
    protected string $defaultBaseDomain = self::DEFAULT_BASE_DOMAIN;

    public function getRequestPrototype(): RequestInterface {
        if ($this->requestPrototype === null) {
            $this->requestPrototype = new Request($this);
        }
        return $this->requestPrototype;
    }

    public function setRequestPrototype(RequestInterface $prototype) {
        $this->requestPrototype = $prototype;
    }

    public function createRequest(): RequestInterface {
        return $this->getRequestPrototype()->createClone();
    }

    public function responsePrototype(): ResponseInterface {
        if (!isset($this->responsePrototype)) {
            $this->responsePrototype = new Response();
        }

        return $this->responsePrototype;
    }

    public function setResponsePrototype(ResponseInterface $prototype) {
        $this->responsePrototype = $prototype;
    }

    public function createResponse(): ResponseInterface {
        return clone $this->responsePrototype();
    }

    public function defaultRequestHeaders(): Headers {
        if (!isset($this->defaultRequestHeaders)) {
            $this->defaultRequestHeaders = new Headers(array(
                'User-Agent' => 'pinterestsdk-php-v'.ApiConfig::SDKVersion,
                'Accept-Encoding' => '*',
            ));
        }

        return $this->defaultRequestHeaders;
    }

    public function setDefaultRequestHeaders(Headers $headers) {
        $this->defaultRequestHeaders = $headers;
    }

    public function defaultBaseDomain(): string {
        return $this->defaultBaseDomain;
    }

    public function setDefaultBaseDomain(string $domain) {
        $this->defaultBaseDomain = $domain;
    }

    public function adapter(): AdapterInterface {
        if ($this->adapter === null) {
            $this->adapter = new CurlAdapter($this);
        }

        return $this->adapter;
    }

    public function setAdapter(AdapterInterface $adapter) {
        $this->adapter = $adapter;
    }

    public function caBundlePath(): string {
        if (!isset($this->caBundlePath)) {
            $this->caBundlePath = __DIR__.DIRECTORY_SEPARATOR
                .str_repeat('..'.DIRECTORY_SEPARATOR, 3)
                .'pin_ca_chain_bundle.crt';
        }

        return $this->caBundlePath;
    }

    public function setCaBundlePath(string $path) {
        $this->caBundlePath = $path;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws RequestException
     */
    public function sendRequest(RequestInterface $request): ResponseInterface {
        $response = $this->adapter()->sendRequest($request);
        $response->setRequest($request);
        $response_content = $response->content();

        if ($response_content === null) {
            throw new EmptyResponseException($response);
        }

        if (is_array($response_content)
            && array_key_exists('error', $response_content)) {

            throw RequestException::create($response);
        }

        return $response;
    }

}