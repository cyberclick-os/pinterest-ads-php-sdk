<?php


namespace PinterestAds\Object\Fields;


use PinterestAds\Enum\AbstractEnum;

class ConversionTagV3GoalMetadataFields extends AbstractEnum
{
    const ATTRIBUTIONWINDOWS = 'attribution_windows';
    const CONVERSIONEVENT = 'conversion_event';
    const CONVERSIONTAGID = 'conversion_tag_d';
    const CPAGOALVALUEINMICROCURRENCY = 'cpa_goal_value_in_micro_currency';

    public function fieldTypes(): array{
        return array(
            'attributionWindows' => 'attribution_windows',
            'conversionEvent' => 'string',
            'conversionTagId' => 'string',
            'cpaGoalValueInMicroCurrency' => 'string'
        );
    }

}