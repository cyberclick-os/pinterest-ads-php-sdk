<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class AdvertiserFields extends AbstractEnum
{
    const ACTIONS = 'actions';
    const BUSINESS_ADDRESS = 'business_address';
    const CAMPAIGN_IDS = 'campaign_ids';
    const COUNTRY = 'country';
    const CREATED_TIME = 'created_time';
    const CURRENCY = 'currency';
    const EXEMPT_ADDITIONAL_TAX = 'exempt_additional_tax';
    const ID = 'id';
    const IS_AGENCY = 'is_agency';
    const IS_AGENCY_PAYING = 'is_agency_paying';
    const IS_ONE_TAP = 'is_one_tap';
    const MERCHANT_ID = 'merchant_id';
    const NAME = 'name';
    const OWNER_USER_ID = 'owner_user_id';
    const REPRESENTED_ADVERTISER_COUNTRY = 'represented_advertiser_country';
    const ROLES = 'roles';
    const SOURCE_INTEGRATION_PLATFORM_TYPE = 'source_integration_platform_type';
    const STATUS = 'status';
    const TEST_ACCOUNT = 'test_account';
    const TYPE = 'type';
    const UPDATED_TIME = 'updated_time';
    const VAT_EXEMPT_NUMBER = 'vat_exempt_number';
    const VAT_NUMBER = 'vat_number';

    public function fieldTypes(): array{
        return array(
            'actions' => 'string',
            'business_address' => 'Object',
            'campaign_ids' => 'string',
            'country' => 'string',
            'created_time' => 'datetime',
            'currency' => 'string',
            'exempt_additional_tax' => 'bool',
            'id' => 'string',
            'is_agency' => 'bool',
            'is_agency_paying' => 'bool',
            'is_one_tap' => 'bool',
            'merchant_id' => 'string',
            'name' => 'string',
            'owner_user_id' => 'string',
            'represented_advertiser_country' => 'string',
            'roles' => 'string',
            'source_integration_platform_type' => 'string',
            'status' => 'string',
            'test_account' => 'string',
            'type' => 'string',
            'updated_time' => 'datetime',
            'vat_exempt_number' => 'string',
            'vat_number' => 'string'
        );
    }
}