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
	$eventid = $_POST['Eventid'];
	$setserial = $_POST['Setserial'];
	$deliveredby = $_POST['Deliveredby'];
	$cssdname = $_POST['Cssdname'];
	$delivereddate = $_POST['Delivereddate'];
	$deliveredtime = $_POST['Deliveredtime'];
	$equipmentdelivered = $_POST['Equipmentdelivered'];
	
	//get deliveredby user ID from deliveredby name
    if($dbh = $_db->get('Users', array('Full_Name','=',$deliveredby))){
		if($dbh->counts() > 0){
			foreach ($dbh->results() as $key) {
				$deliveredbyid = $key->Id;
			}
		}
	}

	//get equipment ID from equipment name
    if($dbh = $_db->get('Equipment_Sets', array('Description','=',$equipmentdelivered))){
		if($dbh->counts() > 0){
			foreach ($dbh->results() as $key) {
				$equipmentdeliveredid = $key->Id;
			}
		}
	}


	//get equipment ID from equipment name
 //    if($dbh = $_db->get('Equipment_Sets', array('Description','=',$equipmenttodeliver))){
	// 	if($dbh->counts() > 0){
	// 		foreach ($dbh->results() as $key) {
	// 			$equipmentid = $key->Id;
	// 		}
	// 	}
	// }



	$timestamp = $delivereddate . " " . $deliveredtime;
	$_db->update('Event_Req', $eventid, array('Status' => 'delivered'));
	
	if(!$_db->insert('Event_Delivery', array(
		'Event_Req_Id' => $eventid,
		'Delivered_By' => $deliveredbyid,
		'CSSD_Name' => $cssdname,
		'Timestamp' => $timestamp,
		'Set_Number' => $equipmentdeliveredid,
		'Set_Serial' => $setserial	
		))) 
		
		{
			

			$_log->error('Could not add delivery update', array(
				'Event_Req_Id' => $eventid,
				'Delivered_By' => $deliveredbyid,
				'CSSD_Name' => $cssdname,
				'Timestamp' => $timestamp,
				'Set_Number' => $equipmentdeliveredid,
				'Set_Serial' => $setserial			
			
			)); // Will be logged 
				//throw new Exception('There was a problem inserting! ');

				echo false;

			
		}else
		{

			
			echo true;


		}
	

		

		

	


?>