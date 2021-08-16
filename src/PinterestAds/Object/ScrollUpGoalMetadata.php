<?php

namespace PinterestAds\Object;

use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\ScrollUpGoalMetadataFields;

class ScrollUpGoalMetadata extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return ScrollUpGoalMetadataFields::instance();
    }
}