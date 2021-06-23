<?php

namespace PinterestAds;

use PinterestAds\ApiConfig;
use PinterestAds\Http\Client;
use PinterestAds\Http\RequestInterface;
use PinterestAds\Http\ResponseInterface;
use PinterestAds\Logger\LoggerInterface;

class Api {

    /**
     * @var string
     */
    const VERSION = ApiConfig::APIVersion;

    protected static Api $instance;

    private SessionInterface $session;

    protected LoggerInterface $logger;

    protected Client $httpClient;

    protected string $defaultApiVersion = self::VERSION;

    public function __construct(
        Client $http_client,
        SessionInterface $session) {
        $this->httpClient = $http_client;
        $this->session = $session;
    }

    public static function init(string $app_id, string $app_secret, string $access_token, bool $log_crash=true) {
        $session = new Session($app_id, $app_secret, $access_token);
        $api = new static(new Client(), $session);
        static::setInstance($api);
        if ($log_crash) {
            //CrashReporter::enable();
        }
        return $api;
    }

    public static function instance(): ?Api {
        return static::$instance;
    }

    public static function setInstance(Api $instance) {
        static::$instance = $instance;
    }

    public function copyWithSession(SessionInterface $session): Api {
        $api = new self($this->httpClient(), $session);
        $api->setDefaultApiVersion($this->defaultApiVersion());
        $api->setLogger($this->logger());
        return $api;
    }

    public static function base64UrlEncode(string $string):string {
        $str = strtr(base64_encode($string), '+/', '-_');
        $str = str_replace('=', '', $str);
        return $str;
    }

    public function prepareRequest(
        string $path,
        string $method = RequestInterface::METHOD_GET,
        array $params = array()): RequestInterface {

        $request = $this->httpClient()->createRequest();
        $request->setMethod($method);
        $request->setApiVersion($this->defaultApiVersion());
        $request->setPath($path);

        if ($method === RequestInterface::METHOD_GET) {
            $params_ref = $request->queryParams();
        } else {
            $params_ref = $request->bodyParams();
        }

        if (!empty($params)) {
            $params_ref->enhance($params);
        }

        $params_ref->enhance($this->session()->getRequestParameters());

        return $request;
    }

    public function executeRequest(RequestInterface $request): ResponseInterface {
        $this->logger()->logRequest('debug', $request);
        $response = $request->execute();
        $this->logger()->logResponse('debug', $response);

        return $response;
    }

    public function session(): SessionInterface
    {
        return $this->session;
    }

    public function logger(): LoggerInterface
    {
        if ($this->logger === null) {
            $this->logger = new NullLogger();
        }
        return $this->logger;
    }

    public function httpClient(): Client
    {
        return $this->httpClient;
    }

    public function defaultApiVersion(): string
    {
        return $this->defaultApiVersion;
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public function setDefaultApiVersion(string $defaultGraphVersion): void
    {
        $this->defaultApiVersion = $defaultGraphVersion;
    }

    public function call(
        string $path,
        string $method = RequestInterface::METHOD_GET,
        array $params = array(),
        array $file_params = array()): ResponseInterface {

        $request = $this->prepareRequest($path, $method, $params);

        if (!empty($file_params)) {
            foreach($file_params as $key => $value) {
                $request->fileParams()->offsetSet($key, $value);
            }
        }

        return $this->executeRequest($request);
    }

}