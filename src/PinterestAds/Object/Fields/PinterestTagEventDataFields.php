<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class PinterestTagEventDataFields extends AbstractEnum
{
    const CURRENCY = 'currency';
    const LEAD_TYPE = 'lead_type';
    const LINE_ITEMS = 'line_items';
    const ORDER_ID = 'order_id';
    const ORDER_QUANTITY = 'order_quantity';
    const PAGE_NAME = 'page_name';
    const PROMO_CODE = 'promo_code';
    const PROPERTY = 'property';
    const SEARCH_QUERY = 'search_query';
    const VALUE = 'value';

    public function fieldTypes(): array{
        return array(
            'currency' => 'string',
            'lead_type' => 'string',
            'line_items' => 'list<LineItem>',
            'order_id' => 'string',
            'order_quantity' => 'string',
            'page_name' => 'string',
            'promo_code' => 'string',
            'property' => 'string',
            'search_query' => 'string',
            'value' => 'string'
        );
    }
}