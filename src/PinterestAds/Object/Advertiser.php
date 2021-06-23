<?php

namespace PinterestAds\Object;

use PinterestAds\ApiRequest;
use PinterestAds\Http\RequestInterface;
use PinterestAds\Object\Fields\AdvertiserFields;
use PinterestAds\TypeChecker;

class Advertiser extends AbstractArchivableCrudObject
{

    public function endpoint(){
        return "advertisers";
    }

    public static function getFieldsEnum(){
        return AdvertiserFields::getInstance();
    }

    public function getCampaigns(array $fields = array(), array $params = array(), $pending = false) {

        $param_types = array(
            'order' => 'string',
            'campaign_status' => 'string',
            'managed_status' => 'string',
            'bookmark' => 'string',
        );
        $enums = array(
        );

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '/advertisers/'.$this->data['id'].'/campaigns',
            new Campaign(),
            'EDGE',
            Campaign::getFieldsEnum()->getValues(),
            new TypeChecker($param_types, $enums)
        );
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
}