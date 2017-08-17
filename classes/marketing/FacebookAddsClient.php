<?php

namespace classes\marketing;

use classes\FacebookBase;
use DateTime;
use FacebookAds\Api;
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
use FacebookAds\Object\Fields\TargetingFields;
use FacebookAds\Object\Search\TargetingSearchTypes;
use FacebookAds\Object\Targeting;
use FacebookAds\Object\TargetingSearch;
use FacebookAds\Object\Values\AdSetBillingEventValues;
use FacebookAds\Object\Values\AdSetOptimizationGoalValues;
use FacebookAds\Object\Values\CampaignObjectiveValues;

class FacebookAddsClient extends FacebookBase{

    public function test(){
        return 'test';
    }

    /**
     * create campaign
     * results here: https://www.facebook.com/ads/manager/account/campaigns/?act=912757582133242&pid=p1
     *
     * @param $name
     * @return Campaign
     */
    public function createCampaign($name){
        $this->debug("Creating Campaign: $name ... \n");
        $accountId = $this->config->get('account_id');

        //$campaign = new Campaign(null, 'act_<AD_ACCOUNT_ID>');
        $campaign = new Campaign(null, 'act_' . $accountId);
        $campaign->setData([
            CampaignFields::NAME => $name,
            CampaignFields::OBJECTIVE => CampaignObjectiveValues::LINK_CLICKS,
        ]);

        $result = $campaign->create(array(
            Campaign::STATUS_PARAM_NAME => Campaign::STATUS_PAUSED,
        ));

        $this->debug("Done! \n");

        return $result;
    }

    /**
     * Search targeting
     * See targeting documentation for more details
     * https://developers.facebook.com/docs/marketing-api/buying-api/targeting/v2.10
     *
     * @param $interest
     * @return array|null
     */
    public function searchTargeting($interest){


        $this->debug("Searching Targeting: $interest ... \n");
        $result = TargetingSearch::search(
            TargetingSearchTypes::INTEREST,
            null,
            $interest);

        $this->debug("Done! \n");

        $data = $result->getResponse()->getContent();

        return $data;
    }

    /**
     * @param $campaignId
     */
    public function createAddSet($campaignId){
        $start_time = (new \DateTime("+1 week"))->format(DateTime::ISO8601);
        $end_time = (new \DateTime("+2 week"))->format(DateTime::ISO8601);

        $accountId = $this->config->get('account_id');

        $adSetName = 'My Ad Set';
        $budget = 10000;
        $bidAmount = 2;

        $targeting = (new Targeting())->setData([
            TargetingFields::GEO_LOCATIONS => [
                'countries' => ['US',],
            ],
            TargetingFields::USER_DEVICE => ['Galaxy S6', 'One m9',],
            TargetingFields::USER_OS => ['android'],
        ]);

        $adset = new AdSet(null, 'act_' . $accountId);
        $adset->setData([
                AdSetFields::NAME => $adSetName,
                AdSetFields::OPTIMIZATION_GOAL => AdSetOptimizationGoalValues::LEAD_GENERATION,
                AdSetFields::BILLING_EVENT => AdSetBillingEventValues::IMPRESSIONS,
                AdSetFields::BID_AMOUNT => $bidAmount,
                AdSetFields::DAILY_BUDGET => $budget,
                AdSetFields::CAMPAIGN_ID => $campaignId,
                AdSetFields::TARGETING => $targeting,
                AdSetFields::START_TIME => $start_time,
                AdSetFields::END_TIME => $end_time,
        ]);

        $result = $adset->create([
            AdSet::STATUS_PARAM_NAME => AdSet::STATUS_PAUSED,
        ]);

        $data = $result;

        return $data;
    }

    public function addCreative()
    {
        $pageId = '372524659830426';
        $url = 'http://yumapos.co.uk/';
        $hash = '<IMAGE_HASH>';
        $accountId = $this->config->get('account_id');
        $name = 'Sample Creative';
        $message = 'try it out';

        $link_data = new AdCreativeLinkData();
        $link_data->setData([
            AdCreativeLinkDataFields::MESSAGE => $message,
            AdCreativeLinkDataFields::LINK => $url,
            AdCreativeLinkDataFields::IMAGE_HASH => $hash,
        ]);

        $object_story_spec = new AdCreativeObjectStorySpec();
        $object_story_spec->setData([
            AdCreativeObjectStorySpecFields::PAGE_ID => $pageId,
            AdCreativeObjectStorySpecFields::LINK_DATA => $link_data,
        ]);

        $creative = new AdCreative(null, 'act_' . $accountId);

        $creative->setData(array(
            AdCreativeFields::NAME => $name,
            AdCreativeFields::OBJECT_STORY_SPEC => $object_story_spec,
        ));

        $result = $creative->create();

        $data = $result;
        return $data;
    }

    public function createAdd(){
        $name = 'My Ad';
        $addSetId = '23842599771120253';
        $creativeId = '';
        $accountId = $this->config->get('account_id');

        $data = [
            AdFields::NAME => $name,
            AdFields::ADSET_ID => $addSetId,
            AdFields::CREATIVE => ['creative_id' => $creativeId,],
        ];

        $ad = new Ad(null, 'act_' . $accountId);
        $ad->setData($data);
        $result = $ad->create([
            Ad::STATUS_PARAM_NAME => Ad::STATUS_PAUSED,
        ]);

        $data = $result;
        return $data;
    }


}