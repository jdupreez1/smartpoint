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
	$stockcode = $_POST['Stockcode'];
	$quantityused = $_POST['Quantity'];
	$patientname = $_POST['Patientname'];
	$patientnumber = $_POST['Patientnumber'];
	$ordernumber = $_POST['Ordernumber'];

	
	if(!$_db->update('Event_Req', $eventid, array('Status' => 'used'))){
		$_log->error('Could not add delivery update');
		echo false;
	}

	if(!$_db->insert('Event_Usage', array(
		'Event_Req_Id' => $eventid,
		'Stock_Code' => $stockcode,
		'Qty_Used' => $quantityused,
		'Qty_Refilled' => '0'
		))) 
		
		{

		$_log->error('Could not add delivery update', array(
			'Event_Req_Id' => $eventid,
			'Stock_Code' => $stockcode,
			'Qty_Used' => $quantityused,
			'Qty_Refilled' => '0'
		
		)); // Will be logged 
			//throw new Exception('There was a problem inserting! ');

			echo false;

		
		}else
		{

			
			echo true;


		} 
	


?>