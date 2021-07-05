<?php

namespace PinterestAds;

class Session implements SessionInterface
{

    protected $appId;
    protected $appSecret;
    protected $accessToken;
    protected $appSecretProof;

    public function __construct($appId, $appSecret, $accessToken)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->accessToken = $accessToken;
    }

    public function appId()
    {
        return $this->appId;
    }

    public function appSecret()
    {
        return $this->appSecret;
    }

    public function accessToken()
    {
        return $this->accessToken;
    }

    public function appSecretProof()
    {
        if ($this->appSecret() === null) {
            return null;
        }
        if ($this->appSecretProof === null) {
            $this->appSecretProof
                = hash_hmac('sha256', $this->accessToken(), $this->appSecret());
        }
        return $this->appSecretProof;
    }

    public function requestParameters(): array
    {
        if ($this->appSecretProof() !== null) {
            return array(
                'access_token' => $this->accessToken(),
                'appsecret_proof' => $this->appSecretProof(),
            );
        } else {
            return array(
                'access_token' => $this->accessToken(),
            );
        }
    }
}