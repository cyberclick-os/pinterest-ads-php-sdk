<?php


namespace PinterestAds\Object\Fields;


use PinterestAds\Enum\AbstractEnum;

class CampaignFields extends AbstractEnum
{
    const AD_GROUP_IDS = 'ad_group_ids';
    const ADVERTISER_ID = 'advertiser_id';
    const BILLING_GROUP = 'billing_group';
    const CAMPAIGN_BUDGET_OPTIMIZATION_ENABLED = 'campaign_budget_optimization_enabled';
    const CREATED_TIME = 'created_time';
    const DAILY_SPEND_CAP = 'daily_spend_cap';
    const END_TIME = 'end_time';
    const ENTITY_STATUS = 'entity_status';
    const ENTITY_VERSION = 'entity_version';
    const ID = 'id';
    const LAST_ENTITY_STATUS_UPDATED_TIME = 'last_entity_status_updated_time';
    const LIFETIME_SPEND_CAP = 'lifetime_spend_cap';
    const NAME = 'name';
    const OBJECTIVE_TYPE = 'objective_type';
    const ORDER_LINE_ID = 'order_line_id';
    const PRODUCT_FILTER = 'product_filter';
    const START_TIME = 'start_time';
    const STATUS = 'status';
    const TRACKING_URLS = 'tracking_urls';
    const TYPE = 'type';
    const UPDATED_TIME = 'updated_time';

    public function fieldTypes(): array{
        return array(
            'ad_group_ids' => 'list<string>',
            'advertiser_id' => 'string',
            'billing_group' => 'string',
            'campaign_budget_optimization_enabled' => 'bool',
            'created_time' => 'int',
            'daily_spend_cap' => 'int',
            'end_time' => 'int',
            'entity_status' => 'string',
            'entity_version' => 'string',
            'id' => 'string',
            'last_entity_status_updated_time' => 'int',
            'lifetime_spend_cap' => 'int',
            'name' => 'string',
            'objective_type' => 'string',
            'order_line_id' => 'string',
            'product_filter' => 'string',
            'start_time' => 'int',
            'status' => 'string',
            'tracking_urls' => 'string',
            'type' => 'string',
            'updated_time' => 'int'
        );
    }
}