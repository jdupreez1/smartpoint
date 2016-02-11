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
	unset($_GET['tweet']);
    try {
    	
		global $twitter, $t;
		$tweet =  $twitter->send('Testing ' . date("Y-m-d H:i:s", $t)); // you can add $imagePath as second argument

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

  if (isset($_GET['tweet'])) {
    runMyFunction();
  }

  if (isset($_GET['read'])) {
    runMyFunction2();
  }


?>


<!DOCTYPE html>
<html>
<head>
	<title>Tweet</title>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-xs-6">
		
			<a  href='./sendTweet.php?tweet=true' class = "btn btn-primary" role="button">Send tweet</a>
			<a  href='./sendTweet.php?read=true' class = "btn btn-primary" role="button">Read tweet</a>
			
		</div>
	</div>
</div>


</body>


</html>