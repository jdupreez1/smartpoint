<?php

//require_once '../Core/init.php';
require_once '../Scripts/twitter.class.php';
// ENTER HERE YOUR CREDENTIALS (see readme.txt)
require_once '../Includes/headinfo.php';// this adds css, javascript, bootstrap

//echo($t . "<br>");
//echo(date("Y-m-d",$t));



$consumerKey = 'hOBgHY1CsvSFY4aGYhhhg6BMw';
$consumerSecret = 'GM4UdZJUPJX6ZKstqXBfExXzDdhv0EsVqipipncvjhIciMvpTH';
$accessToken = '3194650829-gyJZ1oK98AFmri63yQCHM9YW0CRTO53GibqNC9m';
$accessTokenSecret = 'SVyJjWHuGj24PIOtiXGhLYU9xGS3mNqNPuEL6VIkjRdiV';

$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);    //https://code.google.com/p/twitter-php/

$t=time();

function runMyFunction() {
	$message = $_POST['Message'];
	unset($_POST['Message']);
    try {
    	
		global $twitter, $t;
		$message2 = $message  . " " . "http://bit.ly/1DFuMyn" . " " . date("H:i:s", $t);
		$tweet =  $twitter->send($message2); // you can add $imagePath as second argument
		//return true;

	} catch (TwitterException $e) {
		echo 'Error: ' . $e->getMessage();
		
	}
  }

  function runMyFunction2() {
	unset($_GET['read']);

	$channel = null;
    try 
	 {global $twitter, $t;
	 	//$objects = "//statuses//mentions_timeline";
	 	//var_dump($twitter->getLimit());
	 	$channel = $twitter->load(Twitter::REPLIES);
	 } catch (TwitterException $e)
	 {
		echo 'Error: ' . $e->getMessage();
	 }

	 if($channel)
	 {
	 	 foreach ($channel as $status) 
	 	 {
                echo "message: ", $status->text;
                echo  "\r\n";
                echo "posted at " , $status->created_at ;
                 echo  "\r\n";
                echo "posted by " , $status->user->name;
                 echo  "\r\n";
                  echo  "\r\n";
        }	
	 	$channel = null;

	 }
  }

  if (isset($_POST['Message'])) {
    runMyFunction();
  }

  if (isset($_GET['read'])) {
    runMyFunction2();
  }


?>


