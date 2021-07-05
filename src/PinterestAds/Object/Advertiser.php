<?php

namespace PinterestAds\Object;

use PinterestAds\ApiRequest;
use PinterestAds\Http\RequestInterface;
use PinterestAds\Object\Fields\AdvertiserFields;
use PinterestAds\Object\Values\EntityFieldsValues;
use PinterestAds\Object\Values\GranularityValues;
use PinterestAds\Object\Values\LevelValues;
use PinterestAds\Object\Values\MetricsValues;
use PinterestAds\Object\Values\ReportFormatValues;
use PinterestAds\Object\Values\TagVersionValues;
use PinterestAds\Object\Values\WindowDaysValues;
use PinterestAds\Object\Values\ConversionReportTimeValues;
use PinterestAds\Object\Values\DataSourceValues;
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

    public function getAudience(array $fields = array(), array $params = array(), $pending = false) {

        $param_types = array();
        $enums = array();

        $scope = $params['scope'];
        $type = $params['type'];
        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '/advertisers/'.$this->data['id'].'/insights/audience/'.$scope.'/'.$type,
            new Audience(),
            'EDGE',
            Audience::getFieldsEnum()->getValues(),
            new TypeChecker($param_types, $enums)
        );
        $request->addParams(array());
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }

    public function requestAsyncDeliveryMetricsReport(array $fields = array(), array $params = array(), $pending = false) {

        $param_types = array(
            'click_window_days' => 'window_days_enum',
            'conversion_report_time' => 'conversion_report_time_enum',
            'data_source' => 'data_source_enum',
            'end_date' => 'string',
            'engagement_window_days' => 'window_days_enum',
            'entity_fields' => 'list<entity_fields_enum>',
            'filters' => 'string',
            'granularity' => 'granularity_enum',
            'level' => 'level_enum',
            'metrics' => 'metrics_enum',
            'report_format' => 'report_format_enum',
            'tag_version' => 'tag_version_enum',
            'view_window_days' => 'window_days_enum'
        );
        $enums = array(
            'window_days_enum' => WindowDaysValues::getInstance()->getValues(),
            'conversion_report_time_enum' => ConversionReportTimeValues::getInstance()->getValues(),
            'data_source_enum' => DataSourceValues::getInstance()->getValues(),
            'entity_fields_enum' => EntityFieldsValues::getInstance()->getValues(),
            'granularity_enum' => GranularityValues::getInstance()->getValues(),
            'level_enum' => LevelValues::getInstance()->getValues(),
            'metrics_enum' => MetricsValues::getInstance()->getValues(),
            'report_format_enum' => ReportFormatValues::getInstance()->getValues(),
            'tag_version_enum' => TagVersionValues::getInstance()->getValues()
        );

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_POST,
            '/reports/async/'.$this->data['id'].'/delivery_metrics',
            new RequestAsyncAdvertiserDeliveryMetricsReportResponse(),
            'EDGE',
            RequestAsyncAdvertiserDeliveryMetricsReportResponse::getFieldsEnum()->getValues(),
            new TypeChecker($param_types, $enums)
        );
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }

    public function getAsyncDeliveryMetricsReport(array $fields = array(), array $params = array(), $pending = false) {

        $param_types = array(
            'token' => 'string'
        );
        $enums = array();

        $request = new ApiRequest(
            $this->api,
            $this->data['id'],
            RequestInterface::METHOD_GET,
            '/reports/async/'.$this->data['id'].'/delivery_metrics',
            new GetAsyncAdvertiserDeliveryMetricsReportResponse(),
            'EDGE',
            GetAsyncAdvertiserDeliveryMetricsReportResponse::getFieldsEnum()->getValues(),
            new TypeChecker($param_types, $enums)
        );
        $request->addParams($params);
        $request->addFields($fields);
        return $pending ? $request : $request->execute();
    }
}