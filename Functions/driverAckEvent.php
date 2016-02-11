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
	$eventid = $_POST['eventID'];
	$ack = $_POST['Ack'];
	
	$fields = array('Driver_Ack' =>  $_POST['userID'], 'Status' => 'acked');

	if($ack == 1)
	{
		if($dbh2 = $_db->get('Event_Req', array('Id', '=', $eventid,'Driver_Ack','IS NOT',NULL))){
			if($dbh2->counts() > 0){
				echo 'Event already acknowledged by another driver';
				
			}else
			{
				if(!$_db->update('Event_Req',$eventid,$fields)) 
				
				{
					$_log->error('Could not update driver ack into DB'); // Will be logged 
					throw new Exception('There was a problem inserting! ');
		
					
					echo 'Event not acknowledged';
				
				}else
				{
		
					
					echo 'Event acknowledged';
		
		
				} 
			}
		}
	}else 
	{	$fields = array('Driver_Ack' => NULL, 'Status' => 'created');
		
		if(!$_db->update('Event_Req',$eventid,$fields))

		{
			$_log->error('Could not update driver ack into DB'); // Will be logged
			throw new Exception('There was a problem inserting! ');

				
			echo 'Event not unacknowledged';

		}else
		{

				
			echo 'Event unacknowledged';


		}
			
		
	}

	
	


?>