<?php

namespace PinterestAds\Object;

use PinterestAds\Object\Fields\AttributionWindowsFields;

class AttributionWindows extends AbstractObject
{
    public static function getFieldsEnum()
    {
        return AttributionWindowsFields::getInstance();
    }
}