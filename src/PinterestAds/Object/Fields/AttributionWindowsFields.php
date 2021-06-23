<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class AttributionWindowsFields extends AbstractEnum
{
    const CLICKWINDOWDAYS = 'clickWindowDays';
    const ENGAGEMENTWINDOWDAYS = 'engagementWindowDays';
    const VIEWWINDOWDAYS = 'viewWindowDays';

    public function fieldTypes(): array{
        return array(
            'clickWindowDays' => 'int',
            'engagementWindowDays' => 'int',
            'viewWindowDays' => 'int'
        );
    }

}