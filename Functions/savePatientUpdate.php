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

	$patientname = $_POST['Patientname'];
	$patientnumber = $_POST['Patientnumber'];
	$ordernumber = $_POST['Ordernumber'];
	$_db->delete('Event_Patient',array('Event_Req_Id','=',$eventid));
	if(!$_db->insert('Event_Patient', array(
		'Event_Req_Id' => $eventid,
		'Patient_Name' => $patientname,
		'Patient_Nr' => $patientnumber,
		'Order_Nr' => $ordernumber,
		))) 
		
		{
		$_log->error('Could not add delivery update', array(
			'Event_Req_Id' => $eventid,
			'Patient_Name' => $patientname,
			'Patient_Nr' => $patientnumber,
			'Order_Nr' => $ordernumber,	
		
		)); // Will be logged 
			//throw new Exception('There was a problem inserting! ');

			echo false;

		
		}else
		{

			
			echo true;


		} 
	


?>