<?php
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
function sendMessage($chat_id, $msg, $parse_mode, $reply_to_message_id, $disable_web_page_preview, $disable_notification, $reply_markup) {

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
    return "Response: ".$res;
}

function sm($chat_id, $text){
	file_get_contents($tg_api_url.'sendMessage?chat_id='.$chat_id.'&text='.urlencode($text));
}

?>