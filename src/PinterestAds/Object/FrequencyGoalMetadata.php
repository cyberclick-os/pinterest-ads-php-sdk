<?php

namespace PinterestAds\Object;

use PinterestAds\Object\Fields\FrequencyGoalMetadataFields;

class FrequencyGoalMetadata extends AbstractObject
{
    public static function getFieldsEnum()
    {
        return FrequencyGoalMetadataFields::getInstance();
    }

}