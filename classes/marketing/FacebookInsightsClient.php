<?php

namespace classes\marketing;

use classes\FacebookBase;
use FacebookAds\Object\AdCampaign;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Values\AdsInsightsDatePresetValues;
use FacebookAds\Object\Values\InsightsPresets;

class FacebookInsightsClient extends FacebookBase{


    public function getCampaignInsights($campaignId){
        $campaign = new Campaign($campaignId);
        $params = array(
            //'date_preset' => InsightsPresets::LAST_7_DAYS,
            'date_preset' => AdsInsightsDatePresetValues::LAST_7D,
        );
        $insights = $campaign->getInsights([], $params);

        return $insights;
    }
}