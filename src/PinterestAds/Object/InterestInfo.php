<?php

namespace PinterestAds\Object;

use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\InterestInfoFields;

class InterestInfo extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return InterestInfoFields::instance();
    }
}