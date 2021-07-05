<?php

namespace PinterestAds\Object;

use PinterestAds\Object\Fields\RuleFields;

class Rule extends AbstractObject
{
    public static function getFieldsEnum()
    {
        return RuleFields::getInstance();
    }
}