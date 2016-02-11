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
	


	if(!$_db->delete('Event_Req', array('Id','=', $id))) 		
		{
			$_log->error('Could not delete event in Event_Req', array('Id' => $id)); // Will be logged 
			throw new Exception('There was a problem inserting! ');
		}
	if(!$_db->delete('Event_Collect', array('Event_Req_Id','=', $id))) 		
		{
			$_log->error('Could not delete event in Event_Collect', array('Event_Req_Id' => $id)); // Will be logged 
			throw new Exception('There was a problem inserting! ');
		}
	if(!$_db->delete('Event_Delivery', array('Event_Req_Id','=', $id))) 		
	{
		$_log->error('Could not delete event in Event_Delivery', array('Event_Req_Id' => $id)); // Will be logged 
		throw new Exception('There was a problem inserting! ');
	}
	if(!$_db->delete('Event_Patient', array('Event_Req_Id','=', $id))) 		
	{
		$_log->error('Could not delete event in Event_Patient', array('Event_Req_Id' => $id)); // Will be logged 
		throw new Exception('There was a problem inserting! ');
	}
	if(!$_db->delete('Event_Usage', array('Event_Req_Id','=', $id))) 		
	{
		$_log->error('Could not delete event in Event_Usage', array('Event_Req_Id' => $id)); // Will be logged 
		throw new Exception('There was a problem inserting! ');
	}


?>