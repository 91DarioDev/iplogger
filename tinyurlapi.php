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

$filename = 'timed_link.json';
if (!(file_exists($filename))){
  $fp = fopen($filename, 'w');
  fwrite($fp, json_encode(array_timed_link(null, null)));
  fclose($fp);    
}
$valid_period_link = 60; // seconds


function array_timed_link($short_link, $time){
    $timed_link = array(
        "link" => $short_link,
        "time" => $time
    );
    return $timed_link;
}

// set the new timed_link and time it has been taken
function set_timed_link($short_link){
	global $filename;
    $time_now = time();
    $timed_link_in = array_timed_link($short_link, $time_now);
    $fp = fopen($filename, 'w');
    fwrite($fp, json_encode($timed_link_in));
    fclose($fp); 
}

// get the last generated timed link
// if is null, create a new one and set it
// if is outdated, create a new one and set it
function get_timed_link($link){
	global $filename;
	$str = file_get_contents($filename);
    $timed_link_in = json_decode($str, true);
    global $valid_period_link;
    if ($timed_link_in['link'] === null || ($timed_link_in['time']+$valid_period_link) < time()){
    	// generating new link
        $new_short_link = createTinyURl($link);
        set_timed_link($new_short_link);
        return $new_short_link;
    } else {
    	// no need to generate a new link
        return $timed_link_in['link'];
    }
}

// create a new short link
function createTinyUrl($strURL) {
    $tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=" . $strURL);
    return $tinyurl;
}
?>