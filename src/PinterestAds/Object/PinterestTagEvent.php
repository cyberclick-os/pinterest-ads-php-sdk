<?php

namespace PinterestAds\Object;

use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\PinterestTagEventDataFields;

class PinterestTagEvent extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return PinterestTagEventDataFields::instance();
    }
}