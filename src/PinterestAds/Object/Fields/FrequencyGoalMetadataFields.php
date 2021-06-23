<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class FrequencyGoalMetadataFields extends AbstractEnum
{
    const FREQUENCY = 'frequency';
    const TIMERANGE = 'timerange';

    public function fieldTypes(): array{
        return array(
            'frequency' => 'int',
            'timerange' => 'enum'
        );
    }

}