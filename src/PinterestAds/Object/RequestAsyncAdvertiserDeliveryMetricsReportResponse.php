<?php


namespace PinterestAds\Object;


use PinterestAds\Object\Fields\RequestAsyncAdvertiserDeliveryMetricsReportResponseFields;

class RequestAsyncAdvertiserDeliveryMetricsReportResponse extends AbstractObject
{
    public static function getFieldsEnum(){
        return RequestAsyncAdvertiserDeliveryMetricsReportResponseFields::getInstance();
    }
}