<?php
	//ini_set('display_errors',1);  error_reporting(E_ALL);
	require_once '../Core/init.php';
	

	
	$user = new user(null,$_log);
	$_db = db::getInstance();
	
	//var_dump($logger);
	
	

	if(!$user->isLoggedIn()) {
		redirect::to('index.php');
	}	
 
	
	 $companyname = $_POST['Company_Name'];

	
	 
		if(!$_db->insert('Company', array('Company_Name' => $companyname))) 
		{
			$_log->error('Could not insert new company into DB', array('Id' => '', 'Company' => $companyname)); // Will be logged 
			throw new Exception('There was a problem inserting! ');

			echo false;;
		}
		echo true;
		
	


?>