<?php


namespace PinterestAds\Object;


use PinterestAds\Object\Fields\AudienceFields;

class Audience extends AbstractObject
{
    public static function getFieldsEnum()
    {
        return AudienceFields::getInstance();
    }

}