<?php

namespace classes;

class Auth extends FacebookAbstract{

    /**
     * get user long time access token
     * valid for 60 days
     * short time access token is required
     *
     * @param $userAccessTokenShort
     * @return mixed
     */
    public function getLongTimeAccessToken($userAccessTokenShort){
        $config = $this->getConfig();

        $url = $this->getBaseUrl() . 'oauth/access_token?grant_type=fb_exchange_token&client_id=' . $config['appId'] . '&client_secret=' . $config['appSecret'] . '&fb_exchange_token=' . $userAccessTokenShort;

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

    /**
     *
     */
    public function getLeadsForms(){
        $appId = '226402081111820';
        $appSecret = 'b06c27fabd0a8880278d418296556e35';


        /*
        $name = '9R Test';
        $pageId = '1130028110406756';
        $pageAccessToken = 'EAADN6VeeZCwwBAA6MYxYZACtM3ZB0ipoI9ZAbJAbzul1R63eZAlOZArOeUwMJ34U3uaMPEXi4aJZBD1ffagZBocshknsIHtIMstSOatqt04pHcCDhgofda0I22FNCtSS7bYwsYxMDHFJMKZAztqDZAsi9vbwi7KIXHurIZD'; //eternal
        */


        ///*
        $name = '9Round CoMo';
        $pageId = '305065206314263';
        $pageAccessToken = 'EAADN6VeeZCwwBAFqnw4p2PPH19nQOtXFtPHIc4w64UrcDc0tTZBTXg2AVv86lXEi8CZCiDZBK1fgfiXbXPstcYv0ZBZCZC3wZB8ATyJQBHcIOjcFFxhxZA6wpP39ZCDZCrZCHZAgYGsrKWrHcEPFhQxyYGegg1FB7GinCocQZD'; //eternal
        //*/

        $url = 'https://graph.facebook.com/v2.8/'.$pageId.'/leadgen_forms?access_token=' . $pageAccessToken;


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        $result = json_decode($result,true);
    }

    // get leadgen_legal_content
    // $url = 'https://graph.facebook.com/v2.8/'.$pageId.'/leadgen_legal_content?access_token=' . $pageAccessToken;

    public function postLegalContent(){

    }




}