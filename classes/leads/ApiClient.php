<?php

namespace classes\leads;

class ApiClient extends FacebookAbstract{

    /**
     * get facebook page access token from local database
     *
     * @param $pageId
     * @return mixed
     * @throws NotFoundHttpException
     */
    private function getPagesAccessToken($pageId){

        $page = Page::find()->where(['page_id' => $pageId])->one();

        if(!$page){
            throw new NotFoundHttpException('page not exists');
        }

        return $page->access_token;
    }

    /**
     * get leads forms for specific page
     *
     * @param $pageId
     * @return mixed
     */
    public function getLeadForms($pageId){
        $pageAccessToken = $this->getPagesAccessToken($pageId);
        $url = $this->getBaseUrl() . $pageId.'/leadgen_forms?access_token=' . $pageAccessToken;

        $result = $this->curlHelper->sendGetRequest($url);
        $result = json_decode($result,true);
        return $result;
    }

    /**
     * create leads form for specific page
     *
     * @param $pageId
     * @return mixed
     */
    public function createLeadgenForm($pageId){
        $pageAccessToken = $this->getPagesAccessToken($pageId);
        $url = $this->getBaseUrl() . $pageId.'/leadgen_forms';

        $questions = '[{"type": "EMAIL"}, {"type": "CUSTOM", "label": "Select your favorite car"}]';
        $privacyLink = 'https://www.9round.com/privacy';
        $followUpUrl = 'https://www.9round.com/';

        $data = [
            'access_token' => $pageAccessToken,
            'name' => "9Round LeadGen Form",
            'locale' => "EN_US",
            'questions' => $questions,
            'follow_up_action_url' => $followUpUrl,
            'privacy_policy["url"]' => $privacyLink,
        ];

        $result = $this->curlHelper->sendPostRequest($url,$data);
        $result = json_decode($result,true);
        return $result;
    }

    /**
     * check if app subscribed to page webhooks
     *
     * @param $pageId
     * @return bool
     */
    public function checkSubscription($pageId){
        $pageAccessToken = $this->getPagesAccessToken($pageId);

        $url = $this->getBaseUrl() . $pageId.'/subscribed_apps?access_token=' . $pageAccessToken;

        $result = $this->curlHelper->sendGetRequest($url);
        $result = json_decode($result,true);

        //if(isset($result['data']) && count($result['data'])){
        if(count($result['data'])){
            return true;
        }

        return false;
    }

    /**
     * subscribe app to page webhooks
     *
     * @param $pageId
     * @return mixed
     */
    public function subscribeToPageWebhooks($pageId){
        $pageAccessToken = $this->getPagesAccessToken($pageId);

        $data = [
            'access_token' => $pageAccessToken,
        ];

        $url = $this->getBaseUrl() . $pageId.'/subscribed_apps';

        $result = $this->curlHelper->sendPostRequest($url,$data);
        $result = json_decode($result,true);
        return $result['success'];
    }

    /**
     * get facebook lead by id
     * facebook page id is required
     *
     * @param $leadId
     * @param $pageId
     * @return mixed
     */
    public function getLeadgen($leadId, $pageId){
        $pageAccessToken = $this->getPagesAccessToken($pageId);
        $url = $this->getBaseUrl() . $leadId.'?access_token=' . $pageAccessToken;

        $result = $this->curlHelper->sendGetRequest($url);
        $result = json_decode($result,true);
        return $result;
    }

    /**
     * https://developers.facebook.com/docs/marketing-api/guides/lead-ads/forms-creation/v2.8
     *
     * @param $pageId
     * @param $link
     */
    /*public function createLegalContent($pageId,$privacyLink){
        $pageAccessToken = $this->getPagesAccessToken($pageId);
        $url = 'https://graph.facebook.com/v2.8/'.$pageId.'/leadgen_legal_content';

        $data = [
            'access_token' => $pageAccessToken,
            'privacy_policy[url]' => $privacyLink,
        ];

        $result = $this->curlHelper->sendPostRequest($url,$data);
        $result = json_decode($result,true);
        return $result;
    }*/









}