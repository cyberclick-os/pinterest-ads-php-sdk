<?php

namespace PinterestAds\Enum;

use InvalidArgumentException;
use ReflectionClass;

abstract class AbstractEnum implements EnumInstanceInterface {

  protected ?array $map = null;
  protected ?array $names = null;
  protected ?array$values = null;
  protected ?array $valuesMap = null;

  protected static array $instances = array();

  static function className(): string {
    return static::class;
  }

  public static function instance(): AbstractEnum {
    $fqn = static::class;
    if (!array_key_exists($fqn, static::$instances)) {
      static::$instances[$fqn] = new static();
    }

    return static::$instances[$fqn];
  }

  public function arrayCopy(): array {
    if ($this->map === null) {
      $this->map = (new ReflectionClass(static::class))
        ->getConstants();
    }

    return $this->map;
  }

  public function names(): array {
    if ($this->names === null) {
      $this->names = array_keys($this->arrayCopy());
    }

    return $this->names;
  }

  public function values(): array {
    if ($this->values === null) {
      $this->values = array_values($this->arrayCopy());
    }

    return $this->values;
  }

  public function valuesMap(): array {
    if ($this->valuesMap === null) {
      $this->valuesMap = array_fill_keys($this->values(), null);
    }

    return $this->valuesMap;
  }

  public function getValueForName(string|int|float $name) {
    $copy = $this->arrayCopy();
    return array_key_exists($name, $copy)
      ? $copy[$name]
      : null;
  }

  public function assureValueForName(string|int|float $name) {
    $value = $this->getValueForName($name);
    if ($value === null) {
      throw new InvalidArgumentException(
        'Unknown name "'.$name.'" in '.static::className());
    }

    return $value;
  }

  public function isValid(string|int|float $name): bool {
    return array_key_exists($name, $this->arrayCopy());
  }

  public function assureIsValid(string|int|float $name): void {
    if (!array_key_exists($name, $this->arrayCopy())) {
      throw new InvalidArgumentException(
        'Unknown name "'.$name.'" in '.static::className());
    }
  }

  public function isValidValue($value): bool {
    return array_key_exists($value, $this->valuesMap());
  }

  public function assureIsValidValue($value) {
    if (!$this->isValidValue($value)) {
      throw new InvalidArgumentException(
        '"'.$value.'", not a valid value in '.static::className());
    }
  }
}
