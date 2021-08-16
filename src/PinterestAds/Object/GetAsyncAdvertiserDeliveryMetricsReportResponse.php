<?php

namespace PinterestAds\Object;

use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Object\Fields\GetAsyncAdvertiserDeliveryMetricsReportResponseFields;

class GetAsyncAdvertiserDeliveryMetricsReportResponse extends AbstractObject
{
    public static function getFieldsEnum(): AbstractEnum
    {
        return GetAsyncAdvertiserDeliveryMetricsReportResponseFields::instance();
    }
}