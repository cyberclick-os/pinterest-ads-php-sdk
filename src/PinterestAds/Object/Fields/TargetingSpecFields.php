<?php


namespace PinterestAds\Object\Fields;


use PinterestAds\Enum\AbstractEnum;

class TargetingSpecFields extends AbstractEnum
{
    const AGE_BUCKET = 'AGE_BUCKET';
    const APPTYPE = 'APPTYPE';
    const AUDIENCE_EXCLUDE = 'AUDIENCE_EXCLUDE';
    const AUDIENCE_INCLUDE = 'AUDIENCE_INCLUDE';
    const GENDER = 'GENDER';
    const GEO = 'GEO';
    const INTEREST = 'INTEREST';
    const LOCALE = 'LOCALE';
    const LOCATION = 'LOCATION';

    public function fieldTypes(): array{
        return array(
            'AGE_BUCKET' => 'list<string>',
            'APPTYPE' => 'list<string>',
            'AUDIENCE_EXCLUDE' => 'list<string>',
            'AUDIENCE_INCLUDE' => 'list<string>',
            'GENDER' => 'list<string>',
            'GEO' => 'list<string>',
            'INTEREST' => 'list<string>',
            'LOCALE' => 'list<string>',
            'LOCATION' => 'list<string>'
        );
    }
}