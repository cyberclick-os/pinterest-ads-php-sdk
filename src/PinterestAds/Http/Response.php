<?php


namespace PinterestAds\Http;


class Response implements ResponseInterface
{
    protected RequestInterface $request;
    protected int $statusCode;
    protected Headers $headers;
    protected string $body;
    protected ?array $content;

    public function request(): RequestInterface
    {
        return $this->request;
    }

    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function headers(): Headers
    {
        if (!isset($this->headers)) {
            $this->headers = new Headers();
        }
        return $this->headers;
    }

    public function setHeaders(Headers $headers): void
    {
        $this->headers = $headers;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
        $this->content = null;
    }

    public function content(): ?array
    {
        if ($this->content === null) {
            try {
                $this->content = json_decode($this->body(), true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
            }
        }

        return $this->content;
    }

}