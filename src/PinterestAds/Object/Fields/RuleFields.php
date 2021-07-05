<?php


namespace PinterestAds\Object\Fields;


use PinterestAds\Enum\AbstractEnum;

class RuleFields extends AbstractEnum
{
    const COUNTRY = 'country';
    const CUSTOMER_LIST_ID = 'customer_list_id';
    const ENGAGEMENT_DOMAIN = 'engagement_domain';
    const ENGAGEMENT_TYPE = 'engagement_type';
    const EVENT = 'event';
    const EVENT_DATA = 'event_data';
    const SIZE = 'size';
    const STATUS = 'status';
    const TYPE = 'type';
    const UPDATED_TIME = 'updated_time';

    public function fieldTypes(): array{
        return array(
            'country' => 'string',
            'customer_list_id' => 'string',
            'engagement_domain' => 'string',
            'engagement_type' => 'string',
            'event' => 'PinterestTagEvent',
            'event_data' => 'Object',
            'size' => 'int',
            'status' => 'string',
            'type' => 'string',
            'updated_time' => 'int',
        );
    }
}