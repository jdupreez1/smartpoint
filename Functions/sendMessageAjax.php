<?php

require_once '../Core/init.php';
//require_once '../Scripts/twitter.class.php';
// ENTER HERE YOUR CREDENTIALS (see readme.txt)
$user = new user(null,$_log);


if(!$user->isLoggedIn()) {
	redirect::to('../index.php');
}

//echo($t . "<br>");
//echo(date("Y-m-d",$t));
$message = new sendMessage;
echo $message->send($_POST['Type'],$_POST['Data'],$_POST['Originator']);



?>


