<?php

namespace PinterestAds\Object;

use PinterestAds\ApiRequest;
use PinterestAds\Http\RequestInterface;
use PinterestAds\TypeChecker;

class User extends AbstractCrudObject
{
    public function getAdvertisers(array $fields = array(), array $params = array(), $pending = false) {

        $param_types = array(
            'owner_user_id' => 'string',
            'include_acl' => 'bool'
        );
        $enums = array(
        );

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '/advertisers',
            new Advertiser(),
            'EDGE',
            Advertiser::getFieldsEnum()->getValues(),
            new TypeChecker($param_types, $enums)
        );
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
}