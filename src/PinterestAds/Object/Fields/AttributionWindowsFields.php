<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class AttributionWindowsFields extends AbstractEnum
{
    const CLICKWINDOWDAYS = 'click_window_days';
    const ENGAGEMENTWINDOWDAYS = 'engagement_window_days';
    const VIEWWINDOWDAYS = 'view_window_days';

    public function fieldTypes(): array{
        return array(
            'clickWindowDays' => 'int',
            'engagementWindowDays' => 'int',
            'viewWindowDays' => 'int'
        );
    }

}