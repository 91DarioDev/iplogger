<?php

/*
    iplogger - receive on telegram the ip info and the location of the user who clicked the link
    Copyright (C) 2018  91DarioDev github.com/91DarioDev

    iplogger is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published
    by the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    iplogger is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with iplogger.  If not, see <http://www.gnu.org/licenses/>.
*/


require('config.php');

$tg_api_url = 'https://api.telegram.org/bot'.$bot_token.'/';

//post request define
function post($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);

    //$obj = json_decode($response);
    return $response;
}

//SendMessage
function sendMessage($chat_id, $msg, $parse_mode='HTML', $reply_to_message_id=NULL, $disable_web_page_preview=false, $disable_notification=false, $reply_markup=NULL) {
	global $tg_api_url;
	$post = array(
      'chat_id' => $chat_id,
      'text' => $msg,
      'parse_mode' => $parse_mode,
      'disable_web_page_preview' => $disable_web_page_preview,
      'disable_notification' => $disable_notification,
      'reply_to_message_id' => $reply_to_message_id,
      'reply_markup' => $reply_markup
    );

	$res = post($tg_api_url."sendMessage", $post);
  return json_decode($res, true);
}


function sendLocation($chat_id, $latitude, $longitude, $live_period=null, $disable_notification=false, $reply_to_message_id=null, $reply_markup=NULL){
  global $tg_api_url;
  $post = array(
    'chat_id' => $chat_id,
    'latitude' => $latitude,
    'longitude' => $longitude,
    'live_period' => $live_period,
    'disable_notification' => $disable_notification,
    'reply_to_message_id' => $reply_to_message_id,
    'reply_markup' => $reply_markup
  );
  $res = post($tg_api_url."sendLocation", $post);
  return json_decode($res, true);
}

?>
