<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class AudienceFields extends AbstractEnum
{
    const ADVERTISER_ID = 'advertiser_id';
    const AUDIENCE_INSIGHTS_STATUS = 'audience_insights_status';
    const AUDIENCE_TYPE = 'audience_type';
    const CREATED_TIME = 'created_time';
    const DESCRIPTION = 'description';
    const ID = 'id';
    const NAME = 'name';
    const RULE = 'rule';
    const SIZE = 'size';
    const STATUS = 'status';
    const TYPE = 'type';
    const UPDATED_TIME = 'updated_time';

    public function fieldTypes(): array
    {
        return array(
            'advertiser_id' => 'string',
            'audience_insights_status' => 'AudienceInsights',
            'audience_type' => 'string',
            'created_time' => 'int',
            'description' => 'string',
            'id' => 'string',
            'name' => 'string',
            'rule' => 'Rule',
            'size' => 'int',
            'status' => 'string',
            'type' => 'string',
            'updated_time' => 'int'
        );
    }
}