<?php
require('config.php');

function get_ip_info($ip){
  $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
  var_dump($query);
  if($query && $query['status'] == 'success') {
    return $query;
  } else {
    echo 'Unable to get location';
  }
}


function ip2($ip){
  global $api_ipstack_token;
  // Initialize CURL:
  $ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.$api_ipstack_token.'');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  // Store the data:
  $json = curl_exec($ch);
  curl_close($ch);

  // Decode JSON response:
  $api_result = json_decode($json, true);

  // Output the "capital" object inside "location"
  echo $api_result['location']['capital'];
  print_r($api_result);
}
?>
