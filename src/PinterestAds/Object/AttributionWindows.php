<?php

namespace PinterestAds\Object;

use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\AttributionWindowsFields;

class AttributionWindows extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return AttributionWindowsFields::instance();
    }
}