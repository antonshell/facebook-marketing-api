<?php

use classes\Config;
use classes\marketing\FacebookAddsClient;
use classes\marketing\FacebookAudienceClient;
use classes\marketing\FacebookInsightsClient;
use classes\marketing\FacebookLeadsClient;

require 'vendor/autoload.php';

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$apiClient = new FacebookAddsClient();

// Create Campaign
$campaignName = 'Campaign ' . date('Y-m-d H:i:s');
$apiClient->createCampaign($campaignName);




