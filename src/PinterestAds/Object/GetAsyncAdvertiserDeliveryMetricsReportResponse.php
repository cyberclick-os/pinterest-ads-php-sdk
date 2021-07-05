<?php

namespace PinterestAds\Object;

use PinterestAds\Object\Fields\GetAsyncAdvertiserDeliveryMetricsReportResponseFields;

class GetAsyncAdvertiserDeliveryMetricsReportResponse extends AbstractObject
{
    public static function getFieldsEnum(){
        return GetAsyncAdvertiserDeliveryMetricsReportResponseFields::getInstance();
    }
}