<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class LineItemFields extends AbstractEnum
{
    const PRODUCT_BRAND = 'product_brand';
    const PRODUCT_CATEGORY = 'product_category';
    const PRODUCT_ID = 'product_id';
    const PRODUCT_NAME = 'product_name';
    const PRODUCT_PRICE = 'product_price';
    const PRODUCT_QUANTITY = 'product_price';
    const PRODUCT_VARIANT = 'product_variant';
    const PRODUCT_VARIANT_ID = 'product_variant_id';

    public function fieldTypes(): array{
        return array(
            'product_brand' => 'string',
            'product_category' => 'string',
            'product_id' => 'int',
            'product_name' => 'string',
            'product_price' => 'float',
            'product_quantity' => 'int',
            'product_variant' => 'string',
            'product_variant_id' => 'string'
        );
    }
}