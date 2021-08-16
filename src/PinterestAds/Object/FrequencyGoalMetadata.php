<?php

namespace PinterestAds\Object;

use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\FrequencyGoalMetadataFields;

class FrequencyGoalMetadata extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return FrequencyGoalMetadataFields::instance();
    }

}