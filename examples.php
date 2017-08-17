<?php

use classes\marketing\FacebookAddsClient;
use classes\marketing\FacebookAudienceClient;
use classes\marketing\FacebookInsightsClient;
use classes\marketing\FacebookLeadsClient;

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

/*
 * ###############################
 * ### FacebookLeadsClient ###
 * ##############################
 *
 */
$apiClient = new FacebookLeadsClient();

// Get Lead Forms
$pageId = '372524659830426';
$results = $apiClient->getLeadgenForms($pageId);
$apiClient->printArray($results);

// Get form leads
$formId = '110805266268975';
$results = $apiClient->getLeads($formId);
$apiClient->printArray($results);

// Check Page Subscription
$pageId = '372524659830426';
$results = $apiClient->checkSubscription($pageId);
$apiClient->printArray($results);

// Subscribe to page Webhooks
$pageId = '372524659830426';
$results = $apiClient->subscribeToPageWebhooks($pageId);
$apiClient->printArray($results);

// Create Legal Content
$pageId = '372524659830426';
$results = $apiClient->createLegalContent($pageId);
$apiClient->printArray($results);

// Create Context Card
$pageId = '372524659830426';
$results = $apiClient->createContextCard($pageId);
$apiClient->printArray($results);

// Create Leadgen Form
$pageId = '372524659830426';
$legalContentId = '344540259314932';
$contextCardId = '1920764724831390';
$formName = 'LeadAds Form Name';
$actionUrl = 'https://www.9round.com/';
$results = $apiClient->createLeadgenForm($pageId,$legalContentId,$contextCardId,$formName,$actionUrl);
$apiClient->printArray($results);