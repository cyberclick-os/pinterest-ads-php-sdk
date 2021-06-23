<?php

namespace PinterestAds\Object;

use PinterestAds\Object\Fields\ScrollUpGoalMetadataFields;

class ScrollUpGoalMetadata extends AbstractObject
{
    public static function getFieldsEnum()
    {
        return ScrollUpGoalMetadataFields::getInstance();
    }
}