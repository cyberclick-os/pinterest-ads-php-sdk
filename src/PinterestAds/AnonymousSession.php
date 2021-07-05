<?php

namespace PinterestAds;

class AnonymousSession implements SessionInterface
{

    public function requestParameters(): array
    {
        return array();
    }
}