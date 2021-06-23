<?php

namespace PinterestAds\Http;

class Request implements RequestInterface
{

    const PROTOCOL_HTTP = 'http://';

    const PROTOCOL_HTTPS = 'https://';

    protected Client $client;
    protected Headers $headers;
    protected string $method = self::METHOD_GET;
    protected string $protocol = self::PROTOCOL_HTTPS;
    protected string $domain;
    protected string $path;
    protected string $graphVersion;
    protected Parameters $queryParams;
    protected Parameters $bodyParams;
    protected Parameters $fileParams;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->queryParams = new Parameters();
        $this->bodyParams = new Parameters();
        $this->fileParams = new Parameters();
        $this->domain = sprintf(
            "%s.%s",
            Client::DEFAULT_LAST_LEVEL_DOMAIN,
            $this->client->defaultBaseDomain());
    }

    public function __clone() {
        $this->queryParams && $this->queryParams = clone $this->queryParams;
        $this->bodyParams && $this->bodyParams = clone $this->bodyParams;
        $this->fileParams && $this->fileParams = clone $this->fileParams;
    }

    public function client(): Client
    {
        return $this->client;
    }

    public function headers(): Headers
    {
        if (!isset($this->headers)) {
            $this->headers = clone $this->client()->defaultRequestHeaders();
        }
        return $this->headers;
    }

    public function setHeaders(Headers $headers)
    {
        $this->headers = $headers;
    }

    public function protocol(): string
    {
        return $this->protocol;
    }

    public function setProtocol(string $protocol)
    {
        $this->protocol = $protocol;
    }

    public function domain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain)
    {
        $this->domain = $domain;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function apiVersion(): string
    {
        return $this->graphVersion;
    }

    public function setApiVersion(string $graphVersion): void
    {
        $this->graphVersion = $graphVersion;
    }

    public function queryParams(): Parameters
    {
        return $this->queryParams;
    }

    public function setQueryParams(Parameters $queryParams): void
    {
        $this->queryParams = $queryParams;
    }

    public function url(): string
    {
        $delimiter = null;
        if ($this->queryParams()->count()) {
            $delimiter = strpos($this->path(), '?') ? '&' : '?';
        }
        return $this->protocol().$this->domain()
            .'/v'.$this->apiVersion().$this->path()
            .$delimiter
            .http_build_query($this->queryParams()->export(), '', '&');
    }

    public function bodyParams(): Parameters
    {
        return $this->bodyParams;
    }

    public function setBodyParams(Parameters $bodyParams): void
    {
        $this->bodyParams = $bodyParams;
    }

    public function fileParams(): Parameters
    {
        return $this->fileParams;
    }

    public function setFileParams(Parameters $fileParams): void
    {
        $this->fileParams = $fileParams;
    }

    public function execute(): ResponseInterface
    {
        return $this->client()->sendRequest($this);
    }

    public function createClone(): RequestInterface
    {
        return clone $this;
    }

    public function setLastLevelDomain(string $last_level_domain)
    {
        $this->domain = sprintf(
            "%s.%s",
            $last_level_domain,
            $this->client->defaultBaseDomain());
    }
}