<?php

namespace PinterestAds\Http;

interface ResponseInterface
{
    public function request(): RequestInterface;

    public function setRequest(RequestInterface $request);

    public function statusCode(): int;

    public function setStatusCode(int $status_code);

    public function headers(): Headers;

    public function setHeaders(Headers $headers);

    public function body(): string;

    public function setBody(string $body);

    public function content(): ?array;
}