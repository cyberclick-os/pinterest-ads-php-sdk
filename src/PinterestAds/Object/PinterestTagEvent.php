<?php

namespace PinterestAds\Object;

use PinterestAds\Object\Fields\PinterestTagEventDataFields;

class PinterestTagEvent extends AbstractObject
{
    public static function getFieldsEnum()
    {
        return PinterestTagEventDataFields::getInstance();
    }
}