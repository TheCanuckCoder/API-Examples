<?php
// TODO: Create Edit, Remove pages. 
// Create the view pages for a single user and a list of users (JSON).
// Add page should also generate an apiKey in the users 
// table for use later for authentication
// TODO: Find out why a '1' is printing after the String returned
$uid = 1;
$sig = strtoupper(hash_hmac("sha256", 'scharfs1@algonquincollege.com' . '1', 'test'));
$sUrl = "http://courses.dev/api/v2/get/users";
$data = "name=Steven Scharf&email=steve@ottawa-web.ca";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $sUrl);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'USERID: ' . $uid,
	'APIKEY: ' . $sig
));
$vRes = curl_exec($ch);
curl_close($ch);
header('Content-Type: text/json');
echo $vRes;
exit;