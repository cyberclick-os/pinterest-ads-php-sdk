<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class GetAsyncAdvertiserDeliveryMetricsReportResponseFields extends AbstractEnum
{
    const REPORT_STATUS = 'report_status';
    const URL = 'url';

    public function fieldTypes(): array{
        return array(
            'report_status' => 'string',
            'url' => 'string'
        );
    }
}