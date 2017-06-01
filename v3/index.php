<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('classes/class.MyAPI.php');
require_once('classes/class.Users.php');
// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}
try {
	$oServices = new \Services\Users($_REQUEST['action'], $_REQUEST['method'], $_SERVER['HTTP_ORIGIN']);
	echo $oServices->processAPI();
} catch (Exception $e) {
	echo json_encode(array('error' => $e->getMessage()));
}
