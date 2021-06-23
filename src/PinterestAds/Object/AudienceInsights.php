<?php


namespace PinterestAds\Object;


use PinterestAds\Object\Fields\AudienceInsightsFields;

class AudienceInsights extends AbstractObject
{
    public static function getFieldsEnum()
    {
        return AudienceInsightsFields::getInstance();
    }
}