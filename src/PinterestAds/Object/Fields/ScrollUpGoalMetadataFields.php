<?php


namespace PinterestAds\Object\Fields;


use PinterestAds\Enum\AbstractEnum;

class ScrollUpGoalMetadataFields extends AbstractEnum
{
    const SCROLLUPGOALVALUEINMICROCURRENCY = 'scrollupGoalValueInMicroCurrency';

    public function fieldTypes(): array{
        return array(
            'scrollupGoalValueInMicroCurrency' => 'string'
        );
    }
}