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

$apiClient = new FacebookLeadsClient();

// Create Legal Content
$pageId = '372524659830426';
$legalContentId = '344540259314932';
$contextCardId = '1920764724831390';
$formName = 'LeadAds Form Name';
$actionUrl = 'https://www.9round.com/';
$results = $apiClient->createLeadgenForm($pageId,$legalContentId,$contextCardId,$formName,$actionUrl);
$apiClient->printArray($results);



