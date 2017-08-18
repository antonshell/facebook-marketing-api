<?php

namespace classes\marketing;

use classes\FacebookBase;
use DateTime;
use FacebookAds\Api;
use FacebookAds\Http\RequestInterface;
use FacebookAds\Object\Ad;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\AdCreativeLinkData;
use FacebookAds\Object\AdCreativeObjectStorySpec;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\AdCreativeFields;
use FacebookAds\Object\Fields\AdCreativeLinkDataFields;
use FacebookAds\Object\Fields\AdCreativeObjectStorySpecFields;
use FacebookAds\Object\Fields\AdFields;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Fields\LeadgenFormFields;
use FacebookAds\Object\Fields\LeadGenQuestionFields;
use FacebookAds\Object\Fields\TargetingFields;
use FacebookAds\Object\LeadgenForm;
use FacebookAds\Object\LeadGenQuestion;
use FacebookAds\Object\Page;
use FacebookAds\Object\Search\TargetingSearchTypes;
use FacebookAds\Object\Targeting;
use FacebookAds\Object\TargetingSearch;
use FacebookAds\Object\Values\AdSetBillingEventValues;
use FacebookAds\Object\Values\AdSetOptimizationGoalValues;
use FacebookAds\Object\Values\CampaignObjectiveValues;

/**
 * Class FacebookLeadsClient
 * @package classes\marketing
 */
class FacebookLeadsClient extends FacebookBase{

    /**
     * @param $pageId
     * @return \FacebookAds\Object\AbstractObject[]
     */
    public function getLeadgenForms($pageId){
        $page = new Page($pageId);
        $leadgen_forms = $page->getLeadgenForms();
        $data = $leadgen_forms->getObjects();
        return $data;
    }

    /**
     * @param $formId
     * @return \FacebookAds\Object\AbstractObject[]
     */
    public function getLeads($formId){
        $form = new LeadgenForm($formId);
        $leads = $form->getLeads();
        $data = $leads->getObjects();
        return $data;
    }

    /**
     * @param $pageId
     * @return bool
     */
    public function checkSubscription($pageId){
        $pageAccessToken = $this->config->get('access_token');

        $url = $this->getBaseUrl() . $pageId.'/subscribed_apps?access_token=' . $pageAccessToken;

        $result = $this->curlHelper->sendGetRequest($url);
        $result = json_decode($result,true);

        if(count($result['data'])){
            return true;
        }

        return false;
    }

    /**
     * @param $pageId
     * @return mixed
     */
    public function subscribeToPageWebhooks($pageId){
        $pageAccessToken = $this->config->get('access_token');

        $data = [
            'access_token' => $pageAccessToken,
        ];

        $url = $this->getBaseUrl() . $pageId.'/subscribed_apps';

        $result = $this->curlHelper->sendPostRequest($url,$data);
        $result = json_decode($result,true);
        return $result['success'];
    }

    /**
     * @param $pageId
     * @return array|null
     */
    public function createLegalContent($pageId){
        $params = [
            'privacy_policy' => [
                'url' => 'https://www.9round.com/privacy',
                'link_text' => 'Privacy Policy'
            ],
            'custom_disclaimer' => [
                'title' => 'Terms and Conditions',
                'body' => [
                    'text' => 'My custom disclaimer',
                    'url_entities' => [
                        ["offset" => 3, "length" => 6, "url" => 'https://www.9round.com/privacy']
                    ],
                ],
                'checkboxes' => [[
                    "is_required" => false,
                    "is_checked_by_default" => false,
                    "text" => "Allow to contact you",
                    "key" => "checkbox_1",
                ]]
            ],
        ];

        $data = Api::instance()->call(
            '/'.$pageId.'/leadgen_legal_content',
            RequestInterface::METHOD_POST,
            $params
        )->getContent();

        return $data;
    }

    /**
     * @param $pageId
     * @return array|null
     */
    public function createContextCard($pageId){
        $params = [
            'title' => 'title',
            'style' => 'LIST_STYLE',
            'content' => [
                'Easy sign-up flow',
                'Submit your info to have a chance to win',
            ],
            'button_text' => 'Get started',
        ];

        $data = Api::instance()->call(
            '/'.$pageId.'/leadgen_context_cards',
            RequestInterface::METHOD_POST,
            $params
        )->getContent();

        return $data;
    }

    /**
     * @param $pageId
     * @param $legalContentId
     * @param $contextCardId
     * @param $formName
     * @param $actionUrl
     * @return mixed
     */
    public function createLeadgenForm($pageId,$legalContentId,$contextCardId,$formName, $actionUrl){
        $form = new LeadgenForm(null, $pageId);
        $form->setData([
                LeadgenFormFields::NAME => $formName,
                LeadgenFormFields::FOLLOW_UP_ACTION_URL => $actionUrl,
                LeadgenFormFields::QUESTIONS => array(
                    (new LeadGenQuestion())->setData(array(
                        LeadgenQuestionFields::TYPE => 'EMAIL',
                    )),
                ),
                'context_card_id' => $contextCardId,
          'legal_content_id' => $legalContentId,
        ]);

        $result = $form->create();
        return $result;
    }
}