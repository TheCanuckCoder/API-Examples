<?php
ini_set('display_erros', 1);
error_reporting(E_ALL);
require_once('classes/class.MyServices.php'); // including service class to work with database
$oServices = new MyServices();
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $sUrl = "http://courses.dev/api/v1/index.php";
    $sData = 'title=User1&action=add_users&type=json';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $sUrl);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $sData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $vRes = curl_exec($ch);
    curl_close($ch);
    header('Content-Type: text/json');
    echo $vRes;
    exit;
}
// set possible limit
if (isset($_GET['limit']) && (int)$_GET['limit']) {
	$oServices->setLimit((int)$_GET['limit']);
}
// set possible limit
if (isset($_GET['method']) && trim($_GET['method']) > '') {
	$oServices->setMethod($_GET['method']);
}
// process actions
switch ($_REQUEST['action']) {
	case 'users':
			$oServices->getUsers();
			break;
	case 'add_users':
			$oServices->addUsers($_POST['title']);
			break;
}