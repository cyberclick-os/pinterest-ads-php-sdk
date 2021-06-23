<?php

namespace PinterestAds\Object;

use PinterestAds\Object\Fields\OptimizationGoalMetadataFields;

class OptimizationGoalMetadata extends AbstractObject
{
    public static function getFieldsEnum()
    {
        return OptimizationGoalMetadataFields::getInstance();
    }
}