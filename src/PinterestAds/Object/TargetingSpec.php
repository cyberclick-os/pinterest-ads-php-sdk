<?php

namespace PinterestAds\Object;

use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\TargetingSpecFields;

class TargetingSpec extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return TargetingSpecFields::instance();
    }
}