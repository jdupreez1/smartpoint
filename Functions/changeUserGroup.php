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
	
	
	$fields = array('User_Group' =>  $_POST['Group']);

	
	

	if(!$_db->update('Users',$_POST['User'],$fields)) 
		
		{
			$_log->error('Could not update driver ack into DB'); // Will be logged 
			throw new Exception('There was a problem inserting! ');

			echo false;

		
		}else
		{

			
			echo true;


		} 
	


?>