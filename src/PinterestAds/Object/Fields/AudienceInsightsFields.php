<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class AudienceInsightsFields extends AbstractEnum
{
    const LAST_GENERATED_TIMESTAMP = 'last_generated_timestamp';
    const REPORT_STATUS = 'report_status';

    public function fieldTypes(): array{
        return array(
            'last_generated_timestamp' => 'int',
            'report_status' => 'int'
        );
    }

}