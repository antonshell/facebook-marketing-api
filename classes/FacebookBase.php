<?php

namespace classes;

abstract class FacebookBase{

    protected $curlHelper;
    protected $config;

    protected $apiUrl = 'https://graph.facebook.com';
    protected $apiVersion = '2.8';

    public function __construct()
    {
        $this->curlHelper = new CurlHelper();
        $this->config = new Config();
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