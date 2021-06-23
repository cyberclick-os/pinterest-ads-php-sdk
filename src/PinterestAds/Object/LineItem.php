<?php


namespace PinterestAds\Object;


use PinterestAds\Object\Fields\LineItemFields;

class LineItem extends AbstractObject
{
    public static function getFieldsEnum()
    {
        return LineItemFields::getInstance();
    }
}