<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class GetAsyncAdvertiserDeliveryMetricsReportResponseFields extends AbstractEnum
{
    const DATA = 'data';

    public function fieldTypes(): array{
        return array(
            'data' => 'string'
        );
    }
}