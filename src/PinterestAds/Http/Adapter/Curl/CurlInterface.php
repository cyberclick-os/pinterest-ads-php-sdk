<?php

namespace PinterestAds\Http\Adapter\Curl;

use PinterestAds\Http\FileParameter;

interface CurlInterface {


    public function handle();

    public function errno(): int;

    public function error(): string;

    public function escape(string $string): bool|string;

    public function exec();

    public function info(int $opt = 0): int;

    public function init(): void;

    public function pause(int $bitmask): int;

    public function preparePostFileField(string|FileParameter $filepath);

    public function reset(): void;

    public function setOptArray(array $opts);

    public function setOpt(int $option, $value): bool;

    public function unescape(string $string): bool|string;

    public static function version(int $age): array;
}
