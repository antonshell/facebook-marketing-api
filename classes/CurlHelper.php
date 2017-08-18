<?php

namespace classes;

/**
 * Class CurlHelper
 * @package classes
 */
class CurlHelper{

    public $config;

    /**
     * CurlHelper constructor.
     */
    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * @param $url
     * @param $headers
     * @return mixed
     */
    public function sendGetRequest($url,$headers = []){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if(!$this->enableSsl()){
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        if(count($headers)){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $result = curl_exec($ch);
        return $result;
    }

    /**
     * @param $url
     * @param $data
     * @param $headers
     * @return mixed
     */
    public function sendPostRequest($url,$data = '', array $headers = []){
        if(is_array($data)){
            $data = http_build_query($data);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if(!$this->enableSsl()){
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        if(count($headers)){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $result = curl_exec($ch);
        return $result;
    }

    /**
     * @return mixed
     */
    private function enableSsl(){
        return $this->config->get('curl_enable_ssl');
    }
}