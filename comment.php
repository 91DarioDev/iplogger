<?php

$nome = $_GET['nome'];
$commento = $_GET['commento'];

?>
<html>
  <head>
    <title>
    Invio commento
    </title>
  </head>
  <body>
    <font color="red">
    	<h1 align="center">Invio commento</h1>
    </font>
    <hr align="center" />
    <p align="center">
    	<b>Il tuo nome:</b> <?php echo filter_var($nome, FILTER_SANITIZE_SPECIAL_CHARS) ?><br />
    </p>
    <p align="center">
    	<b>il tuo commento:</b> <?php echo filter_var($commento, FILTER_SANITIZE_SPECIAL_CHARS) ?><br />
    </p>
    <hr />
    <p align="center">
    	<b>COMMENTO INVIATO!</b>
    </p>
  </body>
</html>

<?php
require('telegramapi.php');
require('config.php');

$message = "Commento da ".filter_var($nome, FILTER_SANITIZE_SPECIAL_CHARS)." testo: ".filter_var($commento, FILTER_SANITIZE_SPECIAL_CHARS);
sendMessage($bot_admin_id, $message);
?>