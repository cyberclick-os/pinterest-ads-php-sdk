<?php
/**
 * Copyright (c) 2014-present, Facebook, Inc. All rights reserved.
 *
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Facebook.
 *
 * As with any software that integrates with the Facebook platform, your use
 * of this software is subject to the Facebook Developer Principles and
 * Policies [http://developers.facebook.com/policy/]. This copyright notice
 * shall be included in all copies or substantial portions of the software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */

namespace PinterestAds\Http\Adapter\Curl;

use CURLFile;
use PinterestAds\Http\FileParameter;
use RuntimeException;

class Curl55 extends AbstractCurl {

  public function __construct() {
    parent::__construct();
    if (version_compare(PHP_VERSION, '5.5.0') < 0) {
      throw new RuntimeException("Unsupported Curl version");
    }
  }

  public function escape(string $string): bool|string {
    return curl_escape($this->handle, $string);
  }

  public function pause(int $bitmask): int {
    return curl_pause($this->handle, $bitmask);
  }

  public function preparePostFileField(string|FileParameter $filepath): CURLFile {
    $mime_type = $name = ''; // can't be null in HHVM
    if ($filepath instanceof FileParameter) {
      $mime_type = $filepath->mimeType() ?: '';
      $name = $filepath->name() ?: '';
      $filepath = $filepath->path();
    }
    return new CURLFile($filepath, $mime_type, $name);
  }

  public function reset(): void {
    $this->handle && curl_reset($this->handle);
  }

  public static function strerror(int $errornum): ?string {
    return curl_strerror($errornum);
  }

  public function unescape(string $string): bool|string {
    return curl_unescape($this->handle, $string);
  }
}
