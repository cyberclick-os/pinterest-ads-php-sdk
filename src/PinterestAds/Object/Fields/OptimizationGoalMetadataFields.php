<?php


namespace PinterestAds\Object\Fields;
use PinterestAds\Enum\AbstractEnum;

class OptimizationGoalMetadataFields extends AbstractEnum
{
    const CONVERSIONTAGV3GOALMETADATA = 'conversion_tag_v3_goal_metadata';
    const FREQUENCYGOALMETADATA = 'frequency_goal_metadata';
    const SCROLLUPGOALMETADATA = 'scroll_up_goal_metadata';

    public function fieldTypes(): array{
        return array(
            'conversionTagV3GoalMetadata' => 'conversion_tag_v3_goal_metadata',
            'frequencyGoalMetadata' => 'frequency_goal_metadata',
            'scrollupGoalMetadata' => 'scroll_up_goal_metadata'
        );
    }
}