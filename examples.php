<?php

use classes\marketing\FacebookAddsClient;
use classes\marketing\FacebookAudienceClient;
use classes\marketing\FacebookInsightsClient;

echo 'This is just example!';
die();

require 'vendor/autoload.php';

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});


/*
 * ##########################
 * ### FacebookAddsClient ###
 * ##########################
 */
$apiClient = new FacebookAddsClient();

// Create Campaign
$campaignName = 'Campaign ' . date('Y-m-d H:i:s');
$apiClient->createCampaign($campaignName);

// Search Targeting
$interest = 'baseball';
$results = $apiClient->searchTargeting($interest);
$apiClient->printArray($results);

// Create AddSet
$campaignId = '23842599771070253';
$results = $apiClient->createAddSet($campaignId);
$apiClient->printArray($results);

// Create Creative
$results = $apiClient->addCreative();
$apiClient->printArray($results);

// Create Creative
$results = $apiClient->createAdd();
$apiClient->printArray($results);


/*
 * ##########################
 * ### FacebookAuediencesClient ###
 * ##########################
 */
$apiClient = new FacebookAudienceClient();

// Create Audience
$name = 'My new CA';
$description = 'People who bought from my website';
$results = $apiClient->createAudience($name, $description);
$apiClient->printArray($results);

// Add users
$audienceId = '23842599816460253';
$emails = [
    'antonshell@yandex.ru',
    'village@inbox.ru',
];

$results = $apiClient->addPeople($audienceId,$emails);
$apiClient->printArray($results);

// Remove users
$audienceId = '23842599816460253';
$emails = [
    'antonshell@yandex.ru',
    'village@inbox.ru',
];
$results = $apiClient->addPeople($audienceId,$emails);
$apiClient->printArray($results);

/*
 * ###############################
 * ### FacebookInsightsClient ###
 * ##############################
 *
 */
$apiClient = new FacebookInsightsClient();

// Get Campaign Insights
$campaignId = '23842599771070253';
$results = $apiClient->getCampaignInsights($campaignId);
$apiClient->printArray($results);