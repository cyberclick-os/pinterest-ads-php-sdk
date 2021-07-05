<?php


namespace PinterestAds\Http\Adapter\Curl;


use RuntimeException;

abstract class AbstractCurl implements CurlInterface
{

    protected $handle;

    public function __construct() {
        if (!extension_loaded('curl')) {
            throw new RuntimeException("Extension curl not loaded");
        }
    }

    public function __clone() {
        $this->handle = curl_copy_handle($this->handle);
    }

    public function __destruct() {
        if (is_resource($this->handle)) {
            curl_close($this->handle);
        }
    }

    public function handle() {
        return $this->handle;
    }

    public function errno(): int {
        return curl_errno($this->handle);
    }

    public function error(): string {
        return curl_error($this->handle);
    }

    public function exec() {
        return curl_exec($this->handle);
    }

    public function info(int $opt = 0): int {
        return curl_getinfo($this->handle, $opt);
    }

    public function init(): void {
        $this->handle = $this->handle ?: curl_init();
    }

    public function setOptArray(array $opts) {
        curl_setopt_array($this->handle, $opts);
    }

    public function setOpt(int $option, $value): bool {
        return curl_setopt($this->handle, $option, $value);
    }

    public static function version(int $age): array {
        return curl_version($age);
    }
}