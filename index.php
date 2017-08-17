<?php

use classes\Config;
use classes\marketing\FacebookAddsClient;

require 'vendor/autoload.php';

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$apiClient = new FacebookAddsClient();

echo $apiClient->test();

echo 'facebook-marketing-api';