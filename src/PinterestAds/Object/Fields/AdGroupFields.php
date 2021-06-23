<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class AdGroupFields extends AbstractEnum
{
    const AUTO_TARGETING_ENABLED = 'auto_targeting_enabled';
    const BID_IN_MICRO_CURRENCY = 'bid_in_micro_currency';
    const BILLABLE_EVENT = 'billable_event';
    const BUDGET_IN_MICRO_CURRENCY = 'budget_in_micro_currency';
    const BUDGET_TYPE = 'budget_type';
    const CAMPAIGN_ID = 'campaign_id';
    const CAMPAIGN_OBJECTIVE_TYPE = 'campaign_objective_type';
    const CONVERSION_LEARNING_MODE_TYPE = 'conversion_learning_mode_type';
    const CREATED_TIME = 'created_time';
    const END_TIME = 'end_time';
    const ENTITY_VERSION = 'entity_version';
    const FEED_PROFILE_ID = 'feed_profile_id';
    const ID = 'id';
    const LIFETIME_FREQUENCY_CAP = 'lifetime_frequency_cap';
    const NAME = 'name';
    const OPTIMIZATION_GOAL_METADATA = 'optimization_goal_metadata';
    const PACING_DELIVERY_TYPE = 'pacing_delivery_type';
    const PIN_PROMOTION_IDS = 'pin_promotion_ids';
    const PLACEMENT_GROUP = 'placement_group';
    const START_TIME = 'start_time';
    const STATUS = 'status';
    const TARGETING_SPEC = 'targeting_spec';
    const TRACKING_URLS = 'tracking_urls';
    const TYPE = 'type';
    const UPDATED_TIME = 'updated_time';

    public function fieldTypes(): array{
        return array(
            'auto_targeting_enabled' => 'string',
            'bid_in_micro_currency' => 'int',
            'billable_event' => 'string',
            'budget_in_micro_currency' => 'int',
            'budget_type' => 'string',
            'campaign_id' => 'string',
            'campaign_objective_type' => 'string',
            'conversion_learning_mode_type' => 'string',
            'created_time' => 'int',
            'end_time' => 'int',
            'entity_version' => 'string',
            'feed_profile_id' => 'string',
            'id' => 'string',
            'lifetime_frequency_cap' => 'int',
            'name' => 'string',
            'optimization_goal_metadata' => 'OptimizationGoalMetadata',
            'pacing_delivery_type' => 'string',
            'pin_promotion_ids' => 'mixed',
            'placement_group' => 'string',
            'start_time' => 'int',
            'status' => 'string',
            'targeting_spec' => 'TargetingSpec',
            'tracking_urls' => 'string',
            'type' => 'string',
            'updated_time' => 'int'
        );
    }
}