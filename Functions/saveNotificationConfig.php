<?php
	//ini_set('display_errors',1);  error_reporting(E_ALL);
	require_once '../Core/init.php';
	
	$user = new user(null,$_log);
	$_db = db::getInstance();
	
	//var_dump($logger);
	

	if(!$user->isLoggedIn()) {
		redirect::to('index.php');
	}	
 
	 //$coordinates = $_POST['coordinates'];
	//assign received information to variables
	$success = 1;
	for($i = 0; $i < sizeof($_POST['Data']); $i++){
		foreach( $_POST['Data'] as $key => $value) {
			$fields = array();
			foreach( $value as $key2 => $value2) {
				
				
				$fields[$key2] = $value2; 
				
				
			}
			if(!$_db->update('Company_Notification_Config', $key ,$fields))
			
			{
				$success = 0;
				throw new Exception('There was a problem updating! ');
			
				
			
			}else
			{
			
					//do nothing
			
			}
			
		}
		//$Event_Type = $_POST['Data'][$i];
		
	}
	
	if($success == 1)
	{
		echo 'Notification config saved';
	}else
	{
		
		echo 'Notification config not saved';
	}
	
	


?>