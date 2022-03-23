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

namespace PinterestAds;

use ArrayAccess;
use Countable;
use InvalidArgumentException;
use Iterator;
use PinterestAds\Http\RequestInterface;
use PinterestAds\Http\ResponseInterface;
use PinterestAds\Http\Util;
use PinterestAds\Object\AbstractCrudObject;
use PinterestAds\Object\AbstractObject;

class Cursor implements Iterator, Countable, arrayaccess {

  protected ResponseInterface $response;

  protected Api $api;

  protected array $objects = array();

  protected ?int $indexLeft;

  protected ?int $indexRight;

  protected ?int $position;

  protected AbstractObject $objectPrototype;

  protected static bool $defaultUseImplicitFetch = false;

  protected bool $useImplicitFetch;

  public function __construct(
    ResponseInterface $response,
    AbstractObject $object_prototype,
    Api $api = null) {
    $this->response = $response;
    $this->objectPrototype = $object_prototype;
    $this->api = $api ?? Api::instance();
    $this->appendResponse($response);
  }

  protected function createObject(array $object_data):AbstractObject {
    $object = clone $this->objectPrototype;
    $object->setDataWithoutValidation($object_data);
    if ($object instanceof AbstractCrudObject) {
      $object->setApi($this->api);
    }
    return $object;
  }

  protected function assureResponseData(ResponseInterface $response): array {
    $content = $response->content();

    // First, check if the content contains data
    if (isset($content['data']) && is_array($content['data'])) {
      $data = $content['data'];

      // If data is an object wrap the object into an array
      if ($this->isJsonObject($data)) {
        $data = array($data);
      }
      return $data;
    }

    // Second, check if the content contains special entries
    if (isset($content['targetingsentencelines'])) {
      return $content['targetingsentencelines'];
    }
    if (isset($content['adaccounts'])) {
      return $content['adaccounts'];
    }
    if (isset($content['users'])) {
      return $content['users'];
    }

    // Third, check if the content is an array of objects indexed by id
    $is_id_indexed_array = true;
    $objects = array();
    if (is_array($content) && count($content) >= 1) {
      foreach ($content as $key => $value) {
        if ($key === '__fb_trace_id__') {
          continue;
        }

        if ($value !== null &&
            $this->isJsonObject($value) &&
            isset($value['id']) &&
            $value['id'] !== null &&
            $value['id'] === $key) {
          $objects[] = $value;
        } else {
          $is_id_indexed_array = false;
          break;
        }
      }
    } else {
      $is_id_indexed_array = false;
    }
    if ($is_id_indexed_array) {
      return $objects;
    }

    throw new InvalidArgumentException("Malformed response data");
  }

  private function isJsonObject($object): bool {
    if (!is_array($object)) {
      return false;
    }

    // Consider an empty array as not object
    if (empty($object)) {
      return false;
    }

    // A json object is represented by a map instead of a pure list
    return array_keys($object) !== range(0, count($object) - 1);
  }

  protected function prependResponse(ResponseInterface $response) {
    $this->response = $response;
    $data = $this->assureResponseData($response);

    $left_index = $this->indexLeft;
    $count = count($data);
    $position = $count - 1;
    for ($i = $left_index - 1; $i >= $left_index - $count; $i--) {
      $this->objects[$i] = $this->createObject($data[$position--]);
      --$this->indexLeft;
    }
  }

  protected function appendResponse(ResponseInterface $response) {
    $this->response = $response;
    $data = $this->assureResponseData($response);

    if (!isset($this->indexRight)) {
      $this->indexLeft = 0;
      $this->indexRight = -1;
      $this->position = 0;
    }

    $this->indexRight += count($data);

    foreach ($data as $object_data) {
      $this->objects[] = $this->createObject($object_data);
    }
  }

  public static function defaultUseImplicitFetch(): bool {
    return static::$defaultUseImplicitFetch;
  }

  public static function setDefaultUseImplicitFetch(bool $use_implicit_fetch) {
    static::$defaultUseImplicitFetch = $use_implicit_fetch;
  }

  public function useImplicitFetch(): bool {
    return isset($this->useImplicitFetch)
      ? $this->useImplicitFetch
      : static::$defaultUseImplicitFetch;
  }

  public function setUseImplicitFetch(bool $use_implicit_fetch) {
    $this->useImplicitFetch = $use_implicit_fetch;
  }

  public function before(): ?string {
    $content = $this->lastResponse()->content();
    return isset($content['paging']['cursors']['before'])
      ? $content['paging']['cursors']['before']
      : null;
  }

  public function after(): ?string {
    $content = $this->lastResponse()->content();
    return isset($content['paging']['cursors']['after'])
      ? $content['paging']['cursors']['after']
      : null;
  }

  protected function createUndirectionalizedRequest(): RequestInterface {
    $request = $this->lastResponse()->request()->createClone();
    $params = $request->queryParams();
    if (isset($params['before'])) {
      unset($params['before']);
    }
    if (isset($params['after'])) {
      unset($params['after']);
    }

    return $request;
  }

  public function previous(): ?string {
    $content = $this->lastResponse()->content();
    if (isset($content['paging']['previous'])) {
      return $content['paging']['previous'];
    }

    $before = $this->before();
    if ($before !== null) {
      $request = $this->createUndirectionalizedRequest();
      $request->queryParams()->offsetSet('before', $before);
      return $request->url();
    }

    return null;
  }

  public function getNext(): ?string {
    $content = $this->lastResponse()->content();
    if (isset($content['paging']['next'])) {
      return $content['paging']['next'];
    }

    $after = $this->after();
    if ($after !== null) {
      $request = $this->createUndirectionalizedRequest();
      $request->queryParams()->offsetSet('after', $after);
      return $request->url();
    }

    return null;
  }

  protected function createRequestFromUrl(string $url): RequestInterface {
    $components = parse_url($url);
    $request = $this->lastResponse()->request()->createClone();
    $request->setDomain($components['host']);
    $query = isset($components['query'])
      ? Util::parseUrlQuery($components['query'])
      : array();
    $request->queryParams()->enhance($query);

    return $request;
  }

  public function createBeforeRequest(): ?RequestInterface {
    $url = $this->previous();
    return $url !== null ? $this->createRequestFromUrl($url) : null;
  }

  public function createAfterRequest(): ?RequestInterface {
    $url = $this->getNext();
    return $url !== null ? $this->createRequestFromUrl($url) : null;
  }

  public function fetchBefore() {
    $request = $this->createBeforeRequest();
    if (!$request) {
      return;
    }

    $this->prependResponse($request->execute());
  }

  public function fetchAfter() {
    $request = $this->createAfterRequest();
    if (!$request) {
      return;
    }

    $this->appendResponse($request->execute());
  }

  public function getArrayCopy(bool $ksort = false): array {
    if ($ksort) {
      // Sort the main array to improve best case performance in future
      // invocations
      ksort($this->objects);
    }

    return $this->objects;
  }

  public function response(): ResponseInterface {
    return $this->response;
  }

  public function lastResponse(): ResponseInterface {
    return $this->response;
  }

  public function indexLeft(): int {
    return $this->indexLeft;
  }

  public function indexRight():int {
    return $this->indexRight;
  }

  public function rewind() {
    if(isset($this->indexLeft)) $this->position = $this->indexLeft;
  }

  public function end() {
    $this->position = $this->indexRight;
  }

  public function seekTo(int $position) {
    $position = array_key_exists($position, $this->objects) ? $position : null;
    $this->position = $position;
  }

  public function current(): AbstractObject|bool {
    return isset($this->objects[$this->position])
      ? $this->objects[$this->position]
      : false;
  }

  public function key():int {
    return $this->position;
  }

  public function prev() {
    if ($this->position == $this->indexLeft()) {
      if ($this->useImplicitFetch()) {
        $this->fetchBefore();
        if ($this->position == $this->indexLeft()) {
          $this->position = null;
        } else {
          --$this->position;
        }
      } else {
        $this->position = null;
      }
    } else {
      --$this->position;
    }
  }

  public function next() {
    if ($this->position == $this->indexRight()) {
      if ($this->useImplicitFetch()) {
        $this->fetchAfter();
        if ($this->position == $this->indexRight()) {
          $this->position = null;
        } else {
          ++$this->position;
        }
      } else {
        $this->position = null;
      }
    } else {
      ++$this->position;
    }
  }

  public function valid():bool {
    return isset($this->objects[$this->position]);
  }

  public function count():int {
    return count($this->objects);
  }

  public function offsetSet($offset, $value) {
    if ($offset === null) {
      $this->objects[] = $value;
    } else {
      $this->objects[$offset] = $value;
    }
  }

  public function offsetExists($offset):bool {
    return isset($this->objects[$offset]);
  }

  public function offsetUnset($offset) {
    unset($this->objects[$offset]);
  }

  public function offsetGet($offset) {
    return isset($this->objects[$offset]) ? $this->objects[$offset] : null;
  }
}
