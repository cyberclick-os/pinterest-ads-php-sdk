<?php


namespace PinterestAds\Object\Values;


use PinterestAds\Enum\AbstractEnum;

class GranularityValues extends AbstractEnum
{
    const DAY = 'DAY';
    const HOUR = 'HOUR';
    const MONTH = 'MONTH';
    const TOTAL = 'TOTAL';
    const WEEK = 'WEEK';
}