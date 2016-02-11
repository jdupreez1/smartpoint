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
	$invoicedby = $_POST['Invoicedby'];
	$invoicenumber = $_POST['Invoicenumber'];
	$invoiceamount = $_POST['Invoiceamount'];
	$invoicedate = $_POST['Invoicedate'];

	
	//get deliveredby user ID from deliveredby name
 //    if($dbh = $_db->get('Users', array('Full_Name','=',$collectedby))){
	// 	if($dbh->counts() > 0){
	// 		foreach ($dbh->results() as $key) {
	// 			$collectedbyid = $key->Id;
	// 		}
	// 	}
	// }

	//get equipment ID from equipment name
 //    if($dbh = $_db->get('Equipment_Sets', array('Description','=',$equipmentdelivered))){
	// 	if($dbh->counts() > 0){
	// 		foreach ($dbh->results() as $key) {
	// 			$equipmentdeliveredid = $key->Id;
	// 		}
	// 	}
	// }


	//get equipment ID from equipment name
 //    if($dbh = $_db->get('Equipment_Sets', array('Description','=',$equipmenttodeliver))){
	// 	if($dbh->counts() > 0){
	// 		foreach ($dbh->results() as $key) {
	// 			$equipmentid = $key->Id;
	// 		}
	// 	}
	// }

	//$timestamp = $collecteddate . " " . $collectedtime;

	//$_db->update('Event_Req', $eventid, array('Status' => 'invoiced'));
	$_db->delete('Event_Invoice',array('Event_Req_Id','=',$eventid));

	if(!$_db->insert('Event_Invoice', array(
		'Event_Req_Id' => $eventid,
		'Invoiced_By' => $invoicedby,
		'Invoice_Number' => $invoicenumber,
		'Invoice_Amount' => $invoiceamount,
		'Timestamp' => $invoicedate	
		))) 
		
		{
		$_log->error('Could not add collection update', array(
			'Event_Req_Id' => $eventid,
			'Invoiced_By' => $invoicedby,
			'Invoice_Number' => $invoicenumber,
			'Invoice_Amount' => $invoiceamount,
			'Timestamp' => $invoicedate		
		
		)); // Will be logged 
			//throw new Exception('There was a problem inserting! ');

			echo false;

		
		}else
		{

			
			echo true;


		} 
	


?>