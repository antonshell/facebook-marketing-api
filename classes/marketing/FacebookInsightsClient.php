<?php

namespace classes\marketing;

use classes\FacebookBase;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Values\AdsInsightsDatePresetValues;

/**
 * Class FacebookInsightsClient
 * @package classes\marketing
 */
class FacebookInsightsClient extends FacebookBase{

    /**
     * @param $campaignId
     * @return \FacebookAds\ApiRequest|\FacebookAds\Cursor|\FacebookAds\Http\ResponseInterface|null
     */
    public function getCampaignInsights($campaignId){
        $campaign = new Campaign($campaignId);
        $params = ['date_preset' => AdsInsightsDatePresetValues::LAST_7D];
        $insights = $campaign->getInsights([], $params);

        return $insights;
    }
}