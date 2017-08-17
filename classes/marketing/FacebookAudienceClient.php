<?php

namespace classes\marketing;

use classes\FacebookBase;
use DateTime;
use FacebookAds\Api;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\CustomAudience;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Fields\CustomAudienceFields;
use FacebookAds\Object\Fields\TargetingFields;
use FacebookAds\Object\Search\TargetingSearchTypes;
use FacebookAds\Object\Targeting;
use FacebookAds\Object\TargetingSearch;
use FacebookAds\Object\Values\AdSetBillingEventValues;
use FacebookAds\Object\Values\AdSetOptimizationGoalValues;
use FacebookAds\Object\Values\CampaignObjectiveValues;
use FacebookAds\Object\Values\CustomAudienceSubtypes;
use FacebookAds\Object\Values\CustomAudienceTypes;

class FacebookAudienceClient extends FacebookBase{
    /**
     * @param $name
     * @param $description
     */
    public function createAudience($name, $description){
        $accountId = $this->config->get('account_id');

        $audience = new CustomAudience(null, 'act_' . $accountId);
        $audience->setData(array(
            CustomAudienceFields::NAME => $name,
            CustomAudienceFields::SUBTYPE => CustomAudienceSubtypes::CUSTOM,
            CustomAudienceFields::DESCRIPTION => $description,
        ));

        $result = $audience->create();
        return $result;
    }

    /**
     * @param $audienceId
     * @param $emails
     * @return \FacebookAds\ApiRequest|\FacebookAds\Cursor|\FacebookAds\Http\ResponseInterface|null
     */
    public function addPeople($audienceId,$emails){
        $audience = new CustomAudience($audienceId);
        $result = $audience->addUsers($emails, CustomAudienceTypes::EMAIL);
        return $result;
    }

    /**
     * @param $audienceId
     * @param $emails
     * @return \FacebookAds\ApiRequest|\FacebookAds\Cursor|\FacebookAds\Http\ResponseInterface|null
     */
    public function removePeople($audienceId,$emails){
        $audience = new CustomAudience($audienceId);
        $result = $audience->removeUsers($emails, CustomAudienceTypes::EMAIL);
        return $result;
    }
}