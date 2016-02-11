<?php

require_once '../Core/init.php';
//require_once '../Scripts/twitter.class.php';
// ENTER HERE YOUR CREDENTIALS (see readme.txt)


//echo($t . "<br>");
//echo(date("Y-m-d",$t));
$message = new sendMessage;
echo $message->send($_POST['Type'],$_POST['Data'],$_POST['UserID']);



?>


