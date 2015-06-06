<?php

require "vendor/autoload.php";

// https://console.developers.google.com/project
$keys = array(
    'YOUR_DEVELOPER_KEY_1', // app-1
    'YOUR_DEVELOPER_KEY_2', // app-2
    'YOUR_DEVELOPER_KEY_3', // app-3
    // ...
);

$client = new Google_Client_Multi();
$client->setKeys($keys)->prepareMulti();

$service = new Google_Service_Customsearch($client);
try {
    $cse = $service->cse->listCse("weather", array('cx' => 'YOUR_CUSTOM_SEARCH_ENGINE_ID'));
    var_dump($cse->getItems());
} catch(Google_Service_Exception $e) {
    echo $e->getMessage();
} catch(Google_Client_Multi_Exception $e) {
    echo $e->getMessage();
}
