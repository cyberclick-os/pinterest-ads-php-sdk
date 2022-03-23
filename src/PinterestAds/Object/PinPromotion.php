<?php

namespace PinterestAds\Object;

use PinterestAds\ApiRequest;
use PinterestAds\Enum\AbstractEnum;
use PinterestAds\Http\RequestInterface;
use PinterestAds\Object\Fields\PinPromotionFields;
use PinterestAds\TypeChecker;

class PinPromotion extends AbstractCrudObject
{
    public function endpoint(){
        return "ads";
    }

    public static function getFieldsEnum(): AbstractEnum
    {
        return PinPromotionFields::instance();
    }

    public function getSelf(array $fields = array(), array $params = array(), $pending = false) {
        $param_types = array(
        );
        $enums = array(
        );

        $request = new ApiRequest(
            $this->api,
            $this->data['advertiser_id'],
            RequestInterface::METHOD_GET,
            '/ads/'.$this->data['advertiser_id'],
            new PinPromotion(),
            'NODE',
            PinPromotion::getFieldsEnum()->values(),
            new TypeChecker($param_types, $enums)
        );
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
}