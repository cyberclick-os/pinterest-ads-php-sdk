<?php

namespace PinterestAds\Object;

use InvalidArgumentException;
use PinterestAds\ApiConfig;
use PinterestAds\Enum\AbstractEnum;
use PinterestAds\TypeChecker;
use PinterestAds\Enum\EmptyEnum;

class AbstractObject {

  protected array $data = array();
  protected $_type_checker;

  public function __construct() {
    $this->data = static::getFieldsEnum()->valuesMap();
    $this->_type_checker = new TypeChecker(
      static::getFieldTypes(), static::getReferencedEnums());
  }

  protected static function getFieldTypes() {
    $fields_enum = static::getFieldsEnum();
    if (method_exists($fields_enum, 'getFieldTypes')) {
      return $fields_enum->getFieldTypes();
    } else {
      return array();
    }
  }

  protected static function getReferencedEnums() {
    return array();
  }

  public function __set(string $name, $value) {
    if (ApiConfig::TYPE_CHECKER_STRICT_MODE
      && $this->_type_checker->isValidParam($name)
    ) {
      if ($this->_type_checker->isValidParamPair($name, $value)) {
        $this->data[$name] = $value;
      } else {
        throw new InvalidArgumentException(
          $name." and ".$this->exportValue($value)
          ." are not a valid type value pair");
      }
    } else {
      $this->data[$name] = $value;
    }
    return $this;
  }

  public function __get(string $name) {
    if (array_key_exists($name, $this->data)) {
      return $this->data[$name];
    } else {
      throw new InvalidArgumentException(
        $name.' is not a field of '.get_class($this));
    }
  }

  public function __isset(string $name): bool {
    return array_key_exists($name, $this->data);
  }

  public function setData(array $data) {
    foreach ($data as $key => $value) {
      $this->{$key} = $value;
    }
    // Handle class-specific situations
    if (method_exists($this, 'setDataTrigger')) {
      $this->setDataTrigger($data);
    }

    return $this;
  }

  public function setDataWithoutValidation(array $data) {
    foreach ($data as $key => $value) {
      $this->data[$key] = $value;
    }
    // Handle class-specific situations
    if (method_exists($this, 'setDataTrigger')) {
      $this->setDataTrigger($data);
    }
    return $this;
  }

  public function data(): array {
    return $this->data;
  }

  protected function exportValue($value) {
    $result = $value;
    switch (true) {
      case $value === null:
        break;
      case $value instanceof AbstractObject:
        $result = $value->exportData();
        break;
      case is_array($value):
        $result = array();
        foreach ($value as $key => $sub_value) {
          if ($sub_value !== null) {
            $result[$key] = $this->exportValue($sub_value);
          }
        }
        break;
    }
    return $result;
  }

  public function exportData(): array {
    return $this->exportValue($this->data);
  }

  public function exportAllData():array {
    return $this->exportValue($this->data);
  }

  public static function getFieldsEnum(): AbstractEnum {
    return EmptyEnum::instance();
  }

  public static function fields(): array {
    return static::getFieldsEnum()->values();
  }

  public static function className(): string {
    return get_called_class();
  }
}
