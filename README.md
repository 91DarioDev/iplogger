# iplogger

### iplogger - receive on telegram the ip info and the location of the user who clicked the link

# INSTALL AND CONFIGURE

Place the files on the root of your server 

Create a config.php with your data based on config.example.php (your telegram id and your telegram bot token)

# USAGE

send someone the link of your website.
You will receive on telegram his data.

To recognize who clicked you could add in query string the parameter "id" where you can add the value that you prefer. You will get on telegram this parameter along with the info.

To immediately redirect on another page you could add the link of destination as "redir" parameter in query string.

geox param ask the user to share is location to get the accurate gps location. if he does not acconsent you still get the usual data anyways.

Example of a url having all the three optional parameters:

https://iplogger.com/?id=mario_rossi&redir=https://Google.com&geox=true

Of course short your link with external tools before of send it.
