<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class RequestAsyncAdvertiserDeliveryMetricsReportResponseFields extends AbstractEnum
{
    const TOKEN = 'token';

    public function fieldTypes(): array{
        return array(
            'token' => 'string'
        );
    }
}