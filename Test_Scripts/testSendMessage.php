<?php

require_once '../Core/init.php';
//require_once '../Scripts/twitter.class.php';
// ENTER HERE YOUR CREDENTIALS (see readme.txt)
require_once '../Includes/headinfo.php';// this adds css, javascript, bootstrap
require_once '../Includes/slideMenu.php';// this adds css, javascript, bootstrap



$user = new user(null,$_log);
if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}


?>


<!DOCTYPE html>
<html>
<head>
	<title>Tweet</title>


	<script type="text/javascript">
	 userid ="";
	function setID(userID) {
		    userid = userID;
		   
		}

	function sendMessage () {
				

 			$.ajax({   								//ajax call to insert data into DB on save
			      type: "POST",
			      url: "../Test_Scripts/sendMessageAjax.php",
			      data: {Type:"Event_Create",Data:$('#testText').val(),UserID:userid},
			      success: function(data) {
			    	 
			    	 
			    	 console.log(data);
			      }
			    });


		
	}
	
	</script>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-xs-6">
			<textarea id="testText"></textarea>
			<button  onclick="sendMessage()" class = "btn btn-primary" role="button">Send message</button>
		
			
		</div>
	</div>
</div>
	
	<?php
		$myId = $user->data()->Id;
		echo "<script type='text/javascript'> setID($myId); </script>";
		?>


</body>


</html>