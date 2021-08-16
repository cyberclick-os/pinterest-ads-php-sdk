<?php

namespace PinterestAds\Object;

use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\RuleFields;

class Rule extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return RuleFields::instance();
    }
}