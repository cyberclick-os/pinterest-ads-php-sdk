<?php

namespace PinterestAds\Enum;

class EmptyEnum extends AbstractEnum {

  public function arrayCopy(): array {
    return array();
  }

  public function names():array {
    return array();
  }

  public function values(): array {
    return array();
  }

  public function valuesMap(): array {
    return array();
  }
}
