<?php


namespace PinterestAds\Object\Fields;


class OptimizationGoalMetadataFields extends \PinterestAds\Enum\AbstractEnum
{
    const CONVERSIONTAGV3GOALMETADATA = 'conversionTagV3GoalMetadata';
    const FREQUENCYGOALMETADATA = 'frequencyGoalMetadata';
    const SCROLLUPGOALMETADATA = 'scrollupGoalMetadata';

    public function fieldTypes(): array{
        return array(
            'conversionTagV3GoalMetadata' => 'ConversionTagV3GoalMetadata',
            'frequencyGoalMetadata' => 'FrequencyGoalMetadata',
            'scrollupGoalMetadata' => 'ScrollUpGoalMetadata'
        );
    }
}