<?php

use classes\Config;
use classes\marketing\FacebookAddsClient;
use classes\marketing\FacebookAudienceClient;
use classes\marketing\FacebookInsightsClient;

require 'vendor/autoload.php';

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$apiClient = new FacebookInsightsClient();

// Get Campaign Insights
$campaignId = '23842599771070253';
$results = $apiClient->getCampaignInsights($campaignId);
$apiClient->printArray($results);

