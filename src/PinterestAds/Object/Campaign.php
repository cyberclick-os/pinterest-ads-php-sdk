<?php

namespace PinterestAds\Object;

use PinterestAds\ApiRequest;
use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Http\RequestInterface;
use PinterestAds\Object\Fields\CampaignFields;
use PinterestAds\TypeChecker;

class Campaign extends AbstractArchivableCrudObject
{
    public function endpoint(){
        return "campaigns";
    }

    public static function getFieldsEnum(): AbstractEnum
    {
        return CampaignFields::instance();
    }

    public function getSelf(array $fields = array(), array $params = array(), $pending = false) {
        $param_types = array(
        );
        $enums = array(
        );

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '/campaigns/'.$this->data['id'],
            new Campaign(),
            'NODE',
            Campaign::getFieldsEnum()->values(),
            new TypeChecker($param_types, $enums)
        );
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }

    public function getAdGroups(array $fields = array(), array $params = array(), $pending = false) {

        $param_types = array(
            'order' => 'string',
            'ad_group_status' => 'string',
            'bookmark' => 'string'
        );
        $enums = array(
        );

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '/campaigns/'.$this->data['id'].'/ad_groups',
            new AdGroup(),
            'EDGE',
            AdGroup::getFieldsEnum()->values(),
            new TypeChecker($param_types, $enums)
        );
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }

}