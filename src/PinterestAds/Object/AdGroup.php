<?php

namespace PinterestAds\Object;

use PinterestAds\ApiRequest;
use PinterestAds\Http\RequestInterface;
use PinterestAds\Object\Fields\AdGroupFields;
use PinterestAds\Object\Values\OrderValues;
use PinterestAds\Object\Values\StatusValues;
use PinterestAds\TypeChecker;

class AdGroup extends AbstractArchivableCrudObject
{
    public function endpoint(){
        return "ad_groups";
    }

    public static function getFieldsEnum(){
        return AdGroupFields::getInstance();
    }

    public function getSelf(array $fields = array(), array $params = array(), $pending = false) {
        $param_types = array(
            'translate_interests_to_names' => 'bool'
        );
        $enums = array(
        );

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '/ad_groups/'.$this->data['id'],
            new AdGroup(),
            'NODE',
            AdGroup::getFieldsEnum()->getValues(),
            new TypeChecker($param_types, $enums)
        );
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }

    public function getPinPromotions(array $fields = array(), array $params = array(), $pending = false) {

        $param_types = array(
            'order' => 'order_enum',
            'pin_promotion_status' => 'pin_promotion_status_enum',
            'bookmark' => 'string'
        );
        $enums = array(
            'order_enum' => OrderValues::getInstance()->getValues(),
            'pin_promotion_status_enum' => StatusValues::getInstance()->getValues()
        );

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '/ad_groups/'.$this->data['id'].'/pin_promotions',
            new PinPromotion(),
            'EDGE',
            PinPromotion::getFieldsEnum()->getValues(),
            new TypeChecker($param_types, $enums)
        );
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
}