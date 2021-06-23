<?php

namespace PinterestAds\Http\Adapter;

use PinterestAds\Exception\Exception;
use PinterestAds\Http\Adapter\Curl\Curl55;
use PinterestAds\Http\Adapter\Curl\CurlInterface;
use PinterestAds\Http\Client;
use PinterestAds\Http\Headers;
use PinterestAds\Http\RequestInterface;
use PinterestAds\Http\ResponseInterface;

class CurlAdapter extends AbstractAdapter
{

    protected CurlInterface $curl;

    protected array $opts;

    public function __construct(Client $client, CurlInterface $curl = null) {
        parent::__construct($client);
        $this->curl = $curl ? $curl: new Curl55();
        $this->curl->init();
    }

    public function curl(): Curl55{
        return $this->curl;
    }

    public function opts(): array
    {
        if (!isset($this->opts)) {
            $this->opts = array(
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => true
                //CURLOPT_CAINFO => $this->caBundlePath(),
            );
        }
        return $this->opts;
    }

    public function setOpts(array $opts)
    {
        $this->opts = $opts;
    }

    protected function getheaderSize(): int {
        return $this->curl()->info(CURLINFO_HEADER_SIZE);
    }

    protected function extractResponseHeadersAndBody(string $raw_response): array {
        $header_size = $this->getheaderSize();

        $raw_headers = mb_substr($raw_response, 0, $header_size);
        $raw_body = mb_substr($raw_response, $header_size);

        return array(trim($raw_headers), trim($raw_body));
    }

    protected function parseHeaders(Headers $headers, string $raw_headers) {
        $raw_headers = str_replace("\r\n", "\n", $raw_headers);

        // There will be multiple headers if a 301 was followed
        // or a proxy was followed, etc
        $header_collection = explode("\n\n", trim($raw_headers));
        // We just want the last response (at the end)
        $raw_headers = array_pop($header_collection);

        $header_components = explode("\n", $raw_headers);
        foreach ($header_components as $line) {
            if (strpos($line, ': ') === false) {
                $headers['http_code'] = $line;
            } else {
                list ($key, $value) = explode(': ', $line, 2);
                $headers[$key] = $value;
            }
        }
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $response = $this->client()->createResponse();
        $this->curl()->reset();
        $curlopts = array(
            CURLOPT_URL => $request->url(),
        );

        $method = $request->method();
        if ($method !== RequestInterface::METHOD_GET
            && $method !== RequestInterface::METHOD_POST) {
            $curlopts[CURLOPT_CUSTOMREQUEST] = $method;
        }

        $curlopts = $this->opts() + $curlopts;

        if ($request->headers()->count()) {
            $headers = array();
            foreach ($request->headers() as $header => $value) {
                $headers[] = "{$header}: {$value}";
            }
            $curlopts[CURLOPT_HTTPHEADER] = $headers;
        }

        $postfields = array();
        if ($method === RequestInterface::METHOD_POST
            && $request->fileParams()->count()
        ) {
            $postfields = array_merge(
                $postfields,
                array_map(
                    array($this->curl(), 'preparePostFileField'),
                    $request->fileParams()->getArrayCopy()));
        }
        if ($method !== RequestInterface::METHOD_GET
            && $request->bodyParams()->count()) {
            $postfields
                = array_merge($postfields, $request->bodyParams()->export());
        }

        if (!empty($postfields)) {
            $curlopts[CURLOPT_POSTFIELDS] = $postfields;
        }

        $this->curl()->setoptArray($curlopts);
        $raw_response = $this->curl()->exec();

        $status_code = $this->curl()->info(CURLINFO_HTTP_CODE);
        $curl_errno = $this->curl()->errno();
        $curl_error = $curl_errno ? $this->curl()->error() : null;

        $response_parts = $this->extractResponseHeadersAndBody($raw_response);

        $response->setStatusCode($status_code);
        $this->parseHeaders($response->headers(), $response_parts[0]);
        $response->setBody($response_parts[1]);

        if ($curl_errno) {
            throw new Exception($curl_error, $curl_errno);
        }

        return $response;
    }
}