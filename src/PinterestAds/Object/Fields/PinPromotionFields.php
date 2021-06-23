<?php


namespace PinterestAds\Object\Fields;


use PinterestAds\Enum\AbstractEnum;

class PinPromotionFields extends AbstractEnum
{

    const AD_GROUP_ID = 'ad_group_id';
    const ADVERTISER_ID = 'advertiser_id';
    const ANDROID_DEEP_LINK = 'android_deep_link';
    const CAMPAIGN_ID = 'campaign_id';
    const CAMPAIGN_OBJECTIVE_TYPE = 'campaign_objective_type';
    const CAROUSEL_ANDROID_DEEP_LINKS = 'carousel_android_deep_links';
    const CAROUSEL_DESTINATION_URLS = 'carousel_destination_urls';
    const CAROUSEL_IOS_DEEP_LINKS = 'carousel_ios_deep_links';
    const CLICK_TRACKING_URL = 'click_tracking_url';
    const COLLECTION_ITEMS_DESTINATION_URL_TEMPLATE = 'collection_items_destination_url_template';
    const CREATED_TIME = 'created_time';
    const CREATIVE_TYPE = 'creative_type';
    const DESTINATION_URL = 'destination_url';
    const ENTITY_VERSION = 'entity_version';
    const ID = 'id';
    const IOS_DEEP_LINK = 'ios_deep_link';
    const IS_PIN_DELETED = 'is_pin_deleted';
    const IS_REMOVABLE = 'is_removable';
    const NAME = 'name';
    const PIN_ID = 'pin_id';
    const REJECTED_REASONS = 'rejected_reasons';
    const REJECTION_LABELS = 'rejection_labels';
    const REVIEW_STATUS = 'review_status';
    const STATUS = 'status';
    const TRACKING_URLS = 'tracking_urls';
    const TYPE = 'type';
    const UPDATED_TIME = 'updated_time';
    const VIEW_TRACKING_URL = 'view_tracking_url';

    public function fieldTypes(): array{
        return array(
            'ad_group_id' => 'string',
            'advertiser_id' => 'string',
            'android_deep_link' => 'string',
            'campaign_id' => 'string',
            'campaign_objective_type' => 'string',
            'carousel_android_deep_links' => 'string',
            'carousel_destination_urls' => 'string',
            'carousel_ios_deep_links' => 'string',
            'click_tracking_url' => 'string',
            'collection_items_destination_url_template' => 'string',
            'created_time' => 'int',
            'creative_type' => 'string',
            'destination_url' => 'string',
            'entity_version' => 'string',
            'id' => 'string',
            'ios_deep_link' => 'string',
            'is_pin_deleted' => 'bool',
            'is_removable' => 'bool',
            'name' => 'string',
            'pin_id' => 'string',
            'rejected_reasons' => 'string',
            'rejection_labels' => 'string',
            'review_status' => 'string',
            'status' => 'string',
            'tracking_urls' => 'string',
            'type' => 'string',
            'updated_time' => 'int',
            'view_tracking_url' => 'string',
        );
    }

}