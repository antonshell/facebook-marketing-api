<?php

namespace classes;

class Auth extends FacebookBase{

    /**
     * get user long time access token
     * valid for 60 days
     * short time access token is required
     *
     * @param $userAccessTokenShort
     * @return mixed
     */
    public function getLongTimeAccessToken($userAccessTokenShort){
        $appId = $this->config->get('app_id');
        $appSecret = $this->config->get('app_secret');

        $url = $this->getBaseUrl() . 'oauth/access_token?grant_type=fb_exchange_token&client_id=' . $appId . '&client_secret=' . $appSecret . '&fb_exchange_token=' . $userAccessTokenShort;

        $result = $this->curlHelper->sendGetRequest($url);
        $result = json_decode($result,true);
        $accessToken = $result['access_token'];

        return $accessToken;
    }

    /**
     * get user account information
     * also get all pages with access tokens
     * pages access tokens are eternal
     *
     * @return mixed
     */
    public function getAccount(){
        $accessToken = $this->getAccessToken();
        $url = $this->getBaseUrl() . 'me/accounts?access_token=' . $accessToken;

        $result = $this->curlHelper->sendGetRequest($url);
        $result = json_decode($result,true);

        return $result;
    }

    /**
     * get all pages with access tokens
     *
     * @return array
     */
    public function getPages(){
        $accessToken = $this->getAccessToken();
        $url = $this->getBaseUrl() . 'me/accounts?access_token=' . $accessToken;

        $result = $this->curlHelper->sendGetRequest($url);
        $result = json_decode($result,true);

        $data = $result['data'];

        while(isset($result['paging']['next'])){
            $url = $result['paging']['next'];
            $result = $this->curlHelper->sendGetRequest($url);
            $result = json_decode($result,true);
            $data = array_merge($data,$result['data']);
        }

        return $data;
    }
}