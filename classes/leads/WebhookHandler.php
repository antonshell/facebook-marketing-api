<?php

namespace classes\leads;

namespace app\components\integrations\facebook\leads;

use app\models\entity\facebook\Page as FacebookPage;
use app\models\entity\facebook\Lead as FacebookLead;
use app\models\entity\facebook\Log;

/**
 * Class WebhookHandler
 * @package app\components\integrations\facebook\leads
 *
 * facebook leads webhook implementation
 */
class WebhookHandler{
    private $apiClient;

    public function __construct()
    {
        $this->apiClient = new ApiClient();
    }

    public function processWebhook(){
        $this->verify();

        $input = json_decode(file_get_contents('php://input'), true);
        //$this->debug(['input' => file_get_contents('php://input')]);

        $service = new ApiClient();

        $leadgen_id = $input['entry'][0]['changes'][0]['value']['leadgen_id'] ?: '';
        $page_id = $input['entry'][0]['changes'][0]['value']['page_id'] ?: '';

        // check if wehook data correct
        if(!$leadgen_id || !$page_id){
            Log::write(Log::LOG_EVENT_WEBHOOK_INVALID, Log::LOG_LEVEL_ERROR);
            return false;
        }

        $page = FacebookPage::find()->where(['page_id' => $page_id])->one();

        // check if page exists in local db
        if(!$page){
            Log::write(Log::LOG_EVENT_ACCESS_TOKEN_NOT_EXISTS, Log::LOG_LEVEL_ERROR,$page->facebook_page_id);
            return false;
        }

        // check if webhooks enabled for specific page
        if(!$page->webhook_enabled){
            Log::write(Log::LOG_EVENT_WEBHOOK_DISABLED, Log::LOG_LEVEL_INFO,$page->facebook_page_id);
            return false;
        }

        $leadData = $service->getLeadgen($leadgen_id,$page_id);

        // check if lead data correct
        if(!isset($leadData['field_data'])){
            Log::write(Log::LOG_EVENT_CANT_GET_LEAD, Log::LOG_LEVEL_ERROR,$page->facebook_page_id,['response' => $leadData, 'leadgen_id' => $leadgen_id]);
            return false;
        }

        // check lead for duplicates
        $lead = FacebookLead::find()->where(['leadgen_id' => $leadgen_id])->one();
        if($lead){
            Log::write(Log::LOG_EVENT_DUPLICATE_LEAD, Log::LOG_LEVEL_INFO,$page->facebook_page_id,['facebook_lead_id'=> $lead->getId()]);
            return false;
        }

        $name = $leadData['field_data'][1]['values'][0] ?: '';
        $phone = $leadData['field_data'][2]['values'][0] ?: '';
        $email = $leadData['field_data'][0]['values'][0] ?: '';
        $metaData = $this->getMetaData($input,$leadData);

        $lead = new FacebookLead();
        $lead->leadgen_id = $leadgen_id;
        $lead->facebook_page_id = $page->facebook_page_id;
        $lead->name = $name;
        $lead->phone = $phone;
        $lead->email = $email;
        $lead->data = json_encode($metaData);
        $lead->created = $this->getCreatedTime($input);

        $status = $lead->save(false);

        if($status){
            Log::write(Log::LOG_EVENT_WEBHOOK_SUCCESS, Log::LOG_LEVEL_INFO,$page->facebook_page_id,['facebook_lead_id'=> $lead->getId()]);
        }
        else{
            Log::write(Log::LOG_EVENT_CANT_SAVE_LEAD, Log::LOG_LEVEL_ERROR,$page->facebook_page_id);
        }

        return $status;
    }

    /**
     * verify webhook
     */
    private function verify(){
        /**
         * @TODO. Need to implement webhooks verification
         * unfortunatelly, facebook sends empty $_REQUEST
         */
        /*
        $challenge = $_REQUEST['hub_challenge'];
        $verify_token = $_REQUEST['hub_verify_token'];
        // Set this Verify Token Value on your Facebook App
        if ($verify_token === 'QsEsPq8OUpZN') {
            echo $challenge;
        }
        */
    }

    /**
     * convert facebook lead created time to datetime
     *
     * @param $input
     * @return string
     */
    private function getCreatedTime($input){
        $created_time = $input['entry'][0]['changes'][0]['value']['created_time'] ?: time();
        $date = new \DateTime();
        $date->setTimestamp($created_time);
        $created = $date->format('Y-m-d H:i:s');

        return $created;
    }

    /**
     * get webhook metadata
     *
     * @param $input
     * @param $leadData
     * @return array
     */
    private function getMetaData($input,$leadData)
    {
        $pageId = $input['entry'][0]['changes'][0]['value']['page_id'] ?: '';
        $formId = $input['entry'][0]['changes'][0]['value']['form_id'] ?: '';
        $created_time = $leadData['created_time'] ?: '';

        $data = [
            'page_id' => $pageId,
            'form_id' => $formId,
            'created_time' => $created_time,
        ];

        return $data;
    }

    public function debug($data){
        if(is_array($data)){
            $data = http_build_query($data);
        }

        $url = "http://213.33.244.187:5101/9rfb/webhook.php?XDEBUG_SESSION_START=1";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
    }

}