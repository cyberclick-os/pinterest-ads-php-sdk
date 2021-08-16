<?php

namespace PinterestAds\Http\Exception;

use Exception;
use PinterestAds\Http\Headers;
use PinterestAds\Http\ResponseInterface;

class RequestException extends Exception {

    protected ?ResponseInterface $response;

    protected Headers $headers;

    protected ?int $errorCode;

    protected ?int $errorSubcode;

    protected ?string $errorMessage;

    protected ?string $errorUserTitle;

    protected ?string $errorUserMessage;

    protected ?int $errorType;

    protected ?array $errorBlameFieldSpecs;

    protected ?string $facebookTraceId;

    public function __construct(ResponseInterface $response) {
        $this->headers = $response->headers();
        $this->response = $response;
        $error_data = static::errorData($response);

        parent::__construct($error_data['message'], $error_data['code']);

        echo $response->body();

        $this->errorSubcode = $error_data['error_subcode'];
        $this->errorUserTitle = $error_data['error_user_title'];
        $this->errorUserMessage = $error_data['error_user_msg'];
        $this->errorBlameFieldSpecs = $error_data['error_blame_field_specs'];
        $this->facebookTraceId = $error_data['fbtrace_id'];
    }

    public function response(): ?ResponseInterface {
        return $this->response;
    }

    /**
     * @param array|string $array
     * @param string|int $key
     * @param mixed $default
     * @return mixed
     */
    protected static function idx($array, $key, $default = null) {
        if (is_string($array)) {
            $array = json_decode($array, true);
        }

        if (is_null($array)) {
            return null;
        }

        return array_key_exists($key, $array)
            ? $array[$key]
            : $default;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    protected static function errorData(ResponseInterface $response) {
        $response_data = $response->content();
        if (is_null($response_data)) {
            $response_data = array();
        }
        $error_data = static::idx($response_data, 'error', array());

        if (is_string(static::idx($error_data, 'error_data'))) {
            $error_data["error_data"] =
                json_decode(stripslashes(static::idx($error_data, 'error_data')), true);
        }

        if (is_null(static::idx($error_data, 'error_data'))) {
            $error_data["error_data"] = array();
        }

        return array(
            'code' =>
                static::idx($error_data, 'code', static::idx($response_data, 'code')),
            'error_subcode' => static::idx($error_data, 'error_subcode'),
            'message' => static::idx($response_data, 'message'),
            'error_user_title' => static::idx($error_data, 'error_user_title'),
            'error_user_msg' => static::idx($error_data, 'error_user_msg'),
            'error_blame_field_specs' =>
                static::idx(static::idx($error_data, 'error_data', array()),
                    'blame_field_specs'),
            'type' => static::idx($error_data, 'type'),
        );
    }

    public static function create(ResponseInterface $response): RequestException {
        $error_data = static::errorData($response);
        if (in_array(
                $error_data['error_subcode'], array(458, 459, 460, 463, 464, 467))
            || in_array($error_data['code'], array(100, 102, 190))
            || $error_data['type'] === 'OAuthException') {

            return new AuthorizationException($response);
        } else if (in_array($error_data['code'], array(1, 2))) {
            return new ServerException($response);
        } else if (in_array($error_data['code'], array(4, 17, 341))) {

            return new ThrottleException($response);
        } else if ($error_data['code'] == 506) {

            return new ClientException($response);
        } else if ($error_data['code'] == 10
            || ($error_data['code'] >= 200 && $error_data['code'] <= 299)) {
            return new PermissionException($response);
        } else {

            return new self($response);
        }
    }

    public function httpStatusCode(): int {
        return $this->response->statusCode();
    }

    public function errorSubcode(): ?int {
        return $this->errorSubcode;
    }

    public function errorUserTitle(): ?string {
        return $this->errorUserTitle;
    }

    public function errorUserMessage(): ?string {
        return $this->errorUserMessage;
    }

    public function errorBlameFieldSpecs(): ?array {
        return $this->errorBlameFieldSpecs;
    }

    public function facebookTraceId(): ?string {
        return $this->facebookTraceId;
    }

    public function isTransient():bool {
        if ($this->response() !== null) {
            return false;
        }

        $body = $this->response()->body();

        return array_key_exists('error', $body)
            && array_key_exists('is_transient', $body['error'])
            && $body['error']['is_transient'];
    }

    public function headers(): Headers {
        return $this->headers;
    }
}
