<?php
	require_once '../Core/init.php';
		
		if (isset($_POST['Message']) && isset($_POST['Username'])) {

			$message = $_POST['Message'];
			$username = $_POST['Username'];
			unset($_POST['Message']);
			unset($_POST['Username']);
			

			$subject = "Orchestrate Notification";
		
			$headers = 'From: Orchestrate <mariusminny@gmail.com>' . "\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
						
			
			$message2 = "
			<html>
			
			<body>
				<p>". $message ."</p>
			</body>
			</html>
			";
								
								


			echo mail($username , $subject , $message2, $headers );
			
	}else
	{
		echo false;
	}
	
							



?>
