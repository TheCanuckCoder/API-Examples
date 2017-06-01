<?php
session_start();
require "libs/Facebook/autoload.php";
$fb = new Facebook\Facebook([
  'app_id' => '120889698447778', // Replace {app-id} with your app id
  'app_secret' => '17304dc89a940772d2d2a6da34824204',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://courses.dev/api/fb-consume/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';