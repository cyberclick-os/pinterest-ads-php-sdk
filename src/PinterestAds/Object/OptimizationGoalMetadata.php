<?php

namespace PinterestAds\Object;

use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\OptimizationGoalMetadataFields;

class OptimizationGoalMetadata extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return OptimizationGoalMetadataFields::instance();
    }
}