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

namespace PinterestAds\Logger\CurlLogger;

use ArrayObject;

final class JsonNode {

  const INDENT_UNIT = 2;
  const EXPLOSION_THRESHOLD = 78;
  /**
   * @var mixed
   */
  protected $value;
  protected ArrayObject $children;

  /**
   * @param mixed $value
   * @return $this
   * @throws \InvalidArgumentException
   */
  public static function factory($value): JsonNode {
    $object = new self();
    switch (true) {
      case is_object($value):
        $value = (array) $value;
        // fallthrough
      case is_array($value):
        foreach ($value as $key => $sub) {
          $object->children()->offsetSet($key, self::factory($sub));
        }
        // fallthrough
      case is_null($value) || is_scalar($value):
        $object->setValue($value);
        break;
      default:
        throw new \InvalidArgumentException(
          gettype($value).' can\'t be encoded');
    }

    return $object;
  }

  public function __construct() {
    $this->children = new ArrayObject();
  }

  public function value() {
    return $this->value;
  }

  public function setValue($value) {
    $this->value = $value;

    return $this;
  }

  public function children(): ArrayObject {
    return $this->children;
  }

  public function maxTreeChildrenCount(): int {
    $max = $this->children()->count();

    /** @var JsonNode $child */
    foreach ($this->children() as $child) {
      $ith = $child->maxTreeChildrenCount();
      $max = $ith > $max ? $ith : $max;
    }

    return $max;
  }

  protected function padding(int $indent): string {
    return str_repeat(' ', $indent * self::INDENT_UNIT);
  }

  protected function lastChildKey() {
    if ($this->children()->count() === 0) {
      return null;
    }

    $copy = $this->children()->getArrayCopy();
    end($copy);

    return key($copy);
  }

  protected function encodeList(int $indent): string {
    $value = $this->value();
    if (empty($value) || (array_keys($value) === range(0, count($value) - 1))) {
      $is_map = false;
    } else {
      $is_map = true;
    }

    ++$indent;
    $last_key = $this->lastChildKey();

    $buffer = ($is_map ? '{' : '[')."\n";

    /** @var JsonNode $child */
    foreach ($this->children() as $key => $child) {
      $buffer .= sprintf(
        "%s%s%s%s\n",
        $this->padding($indent),
        $is_map ? sprintf("%s: ", json_encode($key)) : '',
        $child->encode($indent),
        $key === $last_key ? '' : ',');
    }

    --$indent;
    $buffer .= $this->padding($indent).($is_map ? '}' : ']');

    return $buffer;
  }

  public function encode(int $indent = 0): string {
    $value = $this->value();
    if (is_array($value) || is_object($value)) {
      if ($this->maxTreeChildrenCount() > 2) {
        return $this->encodeList($indent);
      }

      $ugly = json_encode($value);
      $output_prediction = $this->padding($indent).$ugly;
      if (strlen($output_prediction) > self::EXPLOSION_THRESHOLD) {
        return $this->encodeList($indent);
      }

      return $ugly;
    }

    return json_encode($value);
  }
}
