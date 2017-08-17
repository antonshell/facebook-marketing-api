<?php

namespace classes\marketing;

use classes\FacebookBase;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Values\CampaignObjectiveValues;

class FacebookAddsClient extends FacebookBase{

    public function test(){
        return 'test';
    }

    public function createCampaign(){

        //912757582133242

        $accountId = $this->config->get('account_id');

        //$campaign = new Campaign(null, 'act_<AD_ACCOUNT_ID>');
        $campaign = new Campaign(null, 'act_' . $accountId);
        $campaign->setData(array(
            CampaignFields::NAME => 'My campaign',
            CampaignFields::OBJECTIVE => CampaignObjectiveValues::LINK_CLICKS,
        ));

        $result = $campaign->create(array(
            Campaign::STATUS_PARAM_NAME => Campaign::STATUS_PAUSED,
        ));

        $a = 0;
    }
}