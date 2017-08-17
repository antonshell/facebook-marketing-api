<?php

use classes\Config;
use classes\marketing\ApiClient;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$apiClient = new ApiClient();

echo $apiClient->test();

echo 'facebook-marketing-api';