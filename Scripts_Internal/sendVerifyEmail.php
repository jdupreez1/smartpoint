<?php
	require_once '../Core/init.php';
		
	$_db = db::getInstance();
	
	$username = $_GET['Username'];
	

	if($data = $_db->get('Users',array('Username','=',$username)))
	{


		if($data->counts() > 0)
		{
			$code=$data->first()->Confirm_Hash;

			$subject = "Orchestrate Email Verification";
		
			$headers = "From: Orchestrate <mariusminny@gmail.com>" . "\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1" . "\r\n";
			
						
			
			$message = "
			<html>
			
			<body>
				<p>Please click the activation link below and follow the instructions to verify email address.  </p>
				</br>
			    <p><a href='http://orchestrate.co.za/Scripts_Internal/emailVerify.php?Username=".$username."&ConfirmCode=".$code."'>Activation Link</a></p>
			</body>
			</html>
			";
								
								


			if(mail($username , $subject , $message, $headers ))
			{
				redirect::to('../Includes/Errors/emailSent.php');
			}else
			{
				var_dump("an error occured");
			}
		}
	}

	
							



?>
