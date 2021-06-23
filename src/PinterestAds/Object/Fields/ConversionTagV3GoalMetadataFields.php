<?php


namespace PinterestAds\Object\Fields;


class ConversionTagV3GoalMetadataFields extends \PinterestAds\Enum\AbstractEnum
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