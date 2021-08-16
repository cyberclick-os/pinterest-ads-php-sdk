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
        return "pin_promotions";
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
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '/pin_promotions/'.$this->data['id'],
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