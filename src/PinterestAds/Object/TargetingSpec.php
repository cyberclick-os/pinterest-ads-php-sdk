<?php

namespace PinterestAds\Object;

use PinterestAds\Object\Fields\TargetingSpecFields;

class TargetingSpec extends AbstractObject
{
    public static function getFieldsEnum(){
        return TargetingSpecFields::getInstance();
    }
}