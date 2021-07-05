<?php

namespace PinterestAds\Object;

use PinterestAds\Object\Fields\InterestInfoFields;

class InterestInfo extends AbstractObject
{
    public static function getFieldsEnum()
    {
        return InterestInfoFields::getInstance();
    }
}