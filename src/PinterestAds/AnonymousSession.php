<?php

namespace PinterestAds;

class AnonymousSession implements SessionInterface
{

    public function getRequestParameters(): array
    {
        return array();
    }
}