<?php

namespace PinterestAds\Object;

use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\ConversionTagV3GoalMetadataFields;

class ConversionTagV3GoalMetadata extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return ConversionTagV3GoalMetadataFields::instance();
    }
}