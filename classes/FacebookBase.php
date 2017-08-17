<?php

namespace classes;

use FacebookAds\Api;

abstract class FacebookBase{

    protected $curlHelper;
    protected $config;

    protected $apiUrl = 'https://graph.facebook.com';
    //protected $apiVersion = '2.8';
    protected $apiVersion = '2.10';

    public function __construct()
    {
        $this->curlHelper = new CurlHelper();
        $this->config = new Config();

        $this->initFacebookAddsSdk();

    }

    public function printArray($array){
        echo '<pre>';
        print_r($array);
    }

    protected function initFacebookAddsSdk(){
        $app_id = $this->config->get('app_id');
        $app_secret = $this->config->get('app_secret');
        $access_token = $this->config->get('access_token');

        // Initialize a new Session and instanciate an Api object
        Api::init($app_id, $app_secret, $access_token);

        // The Api object is now available trough singleton
        $api = Api::instance();
    }

    protected function debug($message){
        $debugEnabled = $this->config->get('debug');

        if($debugEnabled){
            echo $message;
        }
    }

    protected function getBaseUrl(){
        $url =  $this->apiUrl . '/v' . $this->apiVersion . '/';
        return $url;
    }


    /*protected function getAccessToken(){
        $config = Yii::$app->config->getGlobalModel();
        $userAccessTokenLong = $config->get('third.facebook_leads.user_access_token');

        return $userAccessTokenLong;
    }

    protected function getConfig(){
        $configModel = Yii::$app->config->getGlobalModel();
        $config = [
            'appId' => $configModel->get('third.facebook_leads.app_id'),
            'appSecret' => $configModel->get('third.facebook_leads.app_secret')
        ];

        return $config;
    }

    protected function getBaseUrl(){
        $url =  $this->apiUrl . '/v' . $this->apiVersion . '/';
        return $url;
    }*/
}