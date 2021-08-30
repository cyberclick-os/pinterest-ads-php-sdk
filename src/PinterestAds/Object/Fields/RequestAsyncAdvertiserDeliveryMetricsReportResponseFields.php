<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class RequestAsyncAdvertiserDeliveryMetricsReportResponseFields extends AbstractEnum
{
    const REPORT_STATUS = 'report_status';
    const TOKEN = 'token';
    const MESSAGE = 'message';

    public function fieldTypes(): array{
        return array(
            'report_status' => 'string',
            'token' => 'string',
            'message' => 'string'
        );
    }
}