<?php


namespace PinterestAds\Object;


use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\AudienceInsightsFields;

class AudienceInsights extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return AudienceInsightsFields::instance();
    }
}