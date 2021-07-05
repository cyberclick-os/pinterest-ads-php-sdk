<?php

namespace PinterestAds\Object\Fields;

use PinterestAds\Enum\AbstractEnum;

class InterestInfoFields extends AbstractEnum
{
    const ID = 'id';
    const INDEX = 'index';
    const KEY = 'key';
    const NAME = 'name';
    const RATIO = 'ratio';

    public function fieldTypes(): array
    {
        return array(
            'id' => 'int',
            'index' => 'int',
            'key' => 'int',
            'name' => 'string',
            'ratio' => 'int'
        );
    }
}