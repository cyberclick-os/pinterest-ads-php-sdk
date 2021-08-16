<?php


namespace PinterestAds\Object;


use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\RequestAsyncAdvertiserDeliveryMetricsReportResponseFields;

class RequestAsyncAdvertiserDeliveryMetricsReportResponse extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return RequestAsyncAdvertiserDeliveryMetricsReportResponseFields::instance();
    }
}