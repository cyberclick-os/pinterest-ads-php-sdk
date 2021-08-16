<?php


namespace PinterestAds\Object\Fields;


use PinterestAds\Enum\AbstractEnum;

class ConversionTagV3GoalMetadataFields extends AbstractEnum
{
    const ATTRIBUTIONWINDOWS = 'attributionWindows';
    const CONVERSIONEVENT = 'conversionEvent';
    const CONVERSIONTAGID = 'conversionTagId';
    const CPAGOALVALUEINMICROCURRENCY = 'cpaGoalValueInMicroCurrency';

    public function fieldTypes(): array{
        return array(
            'attributionWindows' => 'AttributionWindows',
            'conversionEvent' => 'string',
            'conversionTagId' => 'string',
            'cpaGoalValueInMicroCurrency' => 'string'
        );
    }

}