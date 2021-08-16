<?php

namespace PinterestAds\Http\Exception;

use PinterestAds\Http\Exception\RequestException;
use PinterestAds\Http\ResponseInterface;

class EmptyResponseException extends RequestException {

  public function __construct(ResponseInterface $response) {
    $content = array(
      'error' => array(
        'message' => 'Empty Response',
      ));
    $response->setBody(json_encode($content));
    parent::__construct($response);
  }
}
