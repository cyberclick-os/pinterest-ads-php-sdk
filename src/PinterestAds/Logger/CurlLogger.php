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

namespace PinterestAds\Logger;

use PinterestAds\Http\FileParameter;
use PinterestAds\Http\Parameters;
use PinterestAds\Http\RequestInterface;
use PinterestAds\Http\ResponseInterface;
use PinterestAds\Logger\CurlLogger\JsonAwareParameters;

class CurlLogger implements LoggerInterface {

  const PARAM_DEFAULT_FLAG = 'd';
  const PARAM_URLENCODE_FLAG = '-data-urlencode';
  const PARAM_POST_FLAG = 'F';
  const METHOD_DEFAULT_FLAG = '';
  const METHOD_GET_FLAG = 'G';
  const METHOD_PUT_FLAG = 'X PUT';
  const METHOD_DELETE_FLAG = 'X DELETE';
  protected $handle;
  protected bool $jsonPrettyPrint = false;

  public function __construct($handle = null) {
    if (!defined('STDOUT')) {
      define('STDOUT', fopen('php://stdout', 'w'));
    }
    $this->handle = is_resource($handle) ? $handle : STDOUT;
  }

  public function isJsonPrettyPrint(): bool {
    return $this->jsonPrettyPrint;
  }

  public function setJsonPrettyPrint(bool $json_pretty_print) {
    $this->jsonPrettyPrint = $json_pretty_print;
    return $this;
  }

  public static function getMethodFlag(string $method): string {
    switch ($method) {
      case RequestInterface::METHOD_GET:
        return static::METHOD_GET_FLAG;
      case RequestInterface::METHOD_PUT:
        return static::METHOD_PUT_FLAG;
      case RequestInterface::METHOD_DELETE:
        return static::METHOD_DELETE_FLAG;
    }

    return static::METHOD_DEFAULT_FLAG;
  }

  public static function getParamFlag(string $method, string $value): string {
    return $method === RequestInterface::METHOD_POST
      ? static::PARAM_POST_FLAG
      : (strstr($value, "\n")
        ? static::PARAM_URLENCODE_FLAG
        : static::PARAM_DEFAULT_FLAG);
  }

  protected function indent(string $string, int $indent): string {
    return str_replace("\n", " \n".str_repeat(' ', $indent), $string);
  }

  protected function processParams(Parameters $params, string $method, bool $is_file): array {
    $chunks = array();
    if ($this->isJsonPrettyPrint()) {
      $params = new JsonAwareParameters($params);
    }
    foreach ($params->export() as $name => $value) {
      if ($is_file && $params->offsetGet($name) instanceof FileParameter) {
        $value = "@" . $this->normalizeFileParam($params->offsetGet($name));
      } else {
        $value = addcslashes(
          strpos($value, "\n") !== false
            ? $this->indent($value, 2)
            : $value,
          '\'');
      }
      $chunks[$name] = sprintf(
        '-%s \'%s=%s\'',
        $this->getParamFlag($method, $value),
        $name,
        $value);
    }
    return $chunks;
  }

  protected function normalizeFileParam(FileParameter $file_param): string {
    return sprintf('%s%s%s%s%s',
      $file_param->path(),
      $file_param->mimeType() != null ? ";type=" : "",
      $file_param->mimeType(),
      $file_param->name() != null ? ";name=" : "",
      $file_param->name());
  }

  protected function processUrl(RequestInterface $request): string {
    return $request->protocol().$request->domain()
      .'/v'.$request->apiVersion().$request->path();
  }

  protected function flush(string $buffer) {
    fwrite($this->handle, $buffer.PHP_EOL.PHP_EOL);
  }

  public function log($level, string $message, array $context = array()) {
    // We only care about requests
  }

  protected function removeArrayKey(array &$array, $key) {
    if (array_key_exists($key, $array)) {
      $value = $array[$key];
      unset($array[$key]);
      return $value;
    } else {
      return null;
    }
  }

  protected function sortParams(array $params): array {
    $access_token = $this->removeArrayKey($params, 'access_token');
    $appsecret_proof = $this->removeArrayKey($params, 'appsecret_proof');
    $access_token !== null && $params['access_token'] = $access_token;
    $appsecret_proof !== null && $params['appsecret_proof'] = $appsecret_proof;

    return $params;
  }

  public function logRequest(
    string $level, RequestInterface $request, array $context = array()) {

    $new_line = ' \\'.PHP_EOL.'  ';
    $method = $request->method();
    $method_flag = static::getMethodFlag($method);
    $params = $this->sortParams(array_merge(
      $this->processParams($request->queryParams(), $method, false),
      $this->processParams($request->bodyParams(), $method, false),
      $this->processParams($request->fileParams(), $method, true)));

    $buffer = 'curl'.($method_flag ? ' -'.$method_flag : '');
    foreach ($params as $param) {
      $buffer .= $new_line.$param;
    }
    $buffer .= $new_line.$this->processUrl($request);

    $this->flush($buffer);
  }

  public function logResponse(
   string $level, ResponseInterface $response, array $context = array()) {
    // We only care about requests
  }
}
