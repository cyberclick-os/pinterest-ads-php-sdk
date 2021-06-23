<?php

namespace PinterestAds\Object;

use PinterestAds\Object\Fields\ConversionTagV3GoalMetadataFields;

class ConversionTagV3GoalMetadata extends AbstractObject
{
    public static function getFieldsEnum()
    {
        return ConversionTagV3GoalMetadataFields::getInstance();
    }
}