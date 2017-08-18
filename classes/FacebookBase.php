<?php

namespace classes;

use FacebookAds\Api;

/**
 * Class FacebookBase
 * @package classes
 */
abstract class FacebookBase{

    protected $curlHelper;
    protected $config;
    protected $facebookApi;

    protected $apiUrl = 'https://graph.facebook.com';
    //protected $apiVersion = '2.8';
    protected $apiVersion = '2.10';

    /**
     * FacebookBase constructor.
     */
    public function __construct()
    {
        $this->curlHelper = new CurlHelper();
        $this->config = new Config();

        $this->initFacebookAddsSdk();

    }

    /**
     * @param $array
     */
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
        $this->facebookApi = Api::instance();
    }

    /**
     * @param $message
     */
    protected function debug($message){
        $debugEnabled = $this->config->get('debug');

        if($debugEnabled){
            echo $message;
        }
    }

    /**
     * @return string
     */
    protected function getBaseUrl(){
        $url =  $this->apiUrl . '/v' . $this->apiVersion . '/';
        return $url;
    }

    /**
     * @return string
     */
    protected function getAccessToken(){
        return $this->config->get('access_token');
    }
}