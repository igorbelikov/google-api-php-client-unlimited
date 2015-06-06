<?php

require "vendor/autoload.php";

$keys = [
	'AIzaSyDdUg1Ppu37T2mXhrHrUksLg1ZGSOB8eLA', // sapa-2
	'AIzaSyDdUg1Ppu37T2mXhrHrUksLg1ZGSOB8eLA', // sapa-2
	'AIzaSyDdUg1Ppu37T2mXhrHrUksLg1ZGSOB8eLA', // sapa-2
	'AIzaSyDDLHySG-_6dTx1IbLo6BBUX4qi4sZ6BYI', // sapa-1
];

$client = new Google_Client_Multi();
$client->setKeys($keys)->prepareMulti();

$service = new Google_Service_Customsearch($client);
try {
	$cse = $service->cse->listCse("weather", array('cx' => '005037261954542973463:0bv5enakkcc'));
	var_dump($cse->getItems());
} catch(Google_Service_Exception $e) {
	echo $e->getMessage();
} catch(Google_Client_Multi_Exception $e) {
	echo $e->getMessage();
}