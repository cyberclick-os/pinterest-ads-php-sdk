<?php


namespace PinterestAds\Http\Adapter\Curl;


use PinterestAds\Http\FileParameter;
use RuntimeException;

class Curl extends AbstractCurl
{

    public function __construct() {
        parent::__construct();
        if (version_compare(PHP_VERSION, '5.5.0') >= 0) {
            throw new RuntimeException("Unsupported Curl version");
        }
    }

    public function escape(string $string): bool|string {
        return rawurlencode($string);
    }

    public function pause(int $bitmask): int {
        return 0;
    }

    public function preparePostFileField(string|FileParameter $filepath) {
        $mime_type = $name = '';
        if ($filepath instanceof FileParameter) {
            $mime_type = $filepath->mimeType() !== null
                ? sprintf(';type=%s', $filepath->mimeType())
                : '';
            $name = $filepath->name() !== null
                ? sprintf(';filename=%s', $filepath->name())
                : '';
            $filepath = $filepath->path();
        }
        return sprintf('@%s%s%s', $filepath, $mime_type, $name);
    }

    public function reset(): void {
        $this->handle && curl_close($this->handle);
        $this->handle = curl_init();
    }

    public static function strError(int $errorNum): ?string {
        return curl_strerror($errorNum);
    }

    public function unescape(string $string): bool|string {
        return curl_unescape($this->handle, $string);
    }
}