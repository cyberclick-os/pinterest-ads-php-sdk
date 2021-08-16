<?php


namespace PinterestAds\Object;


use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\AudienceFields;

class Audience extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return AudienceFields::instance();
    }

}