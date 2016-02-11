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
	$id = $_POST['Id'];
	
	$newoperationdate = $_POST['Newoperationdate'];
	$newoperationtime = $_POST['Newoperationtime']; 
	
	$newoperationDateAndTime = $newoperationdate . " " . $newoperationtime;

	if(!$_db->update('Event_Req', $id ,array(		
		'Operation_Date' => $newoperationDateAndTime		
		))) 
		
		{
			$_log->error('Could not insert new event into DB', array(
				'Operation_Date' => $newoperationDateAndTime,
		)); // Will be logged 
			throw new Exception('There was a problem inserting! ');

			echo false;

		
		}else
		{

			
			echo true;


		} 
	


?>