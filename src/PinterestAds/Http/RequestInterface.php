<?php


namespace PinterestAds\Http;


interface RequestInterface
{
    public const METHOD_DELETE = 'DELETE';
    public const METHOD_GET    = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT  = 'PUT';

    public function __construct(Client $client);

    public function client(): Client;

    public function headers(): Headers;

    public function setHeaders(Headers $headers);

    public function protocol(): string;

    public function setProtocol(string $protocol);

    public function domain(): string;

    public function setDomain(string $domain);

    public function setLastLevelDomain(string $last_level_domain);

    public function method(): string;

    public function setMethod(string $method);

    public function path(): string;

    public function setApiVersion(string $version);

    public function apiVersion();

    public function setPath(string $path);

    public function queryParams(): Parameters;

    public function setQueryParams(Parameters $params);

    public function url(): string;

    public function bodyParams(): Parameters;

    public function setBodyParams(Parameters $params);

    public function fileParams(): Parameters;

    public function setFileParams(Parameters $params);

    public function execute(): ResponseInterface;
    /**
     * Required for Mocking request/response chaining
     */
    public function createClone(): RequestInterface;
}