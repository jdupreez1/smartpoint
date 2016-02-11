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
	$quantityrefilled = $_POST['Quantityrefilled'];
	
	$_db->update('Event_Req', $eventid, array('Status' => 'closed'));

	if(!$_db->updateByStockCode('Event_Usage',$eventid, $stockcode, array(	
		'Qty_Refilled' => $quantityrefilled,

		))) 
		
		{

		$_log->error('Could not add refill update', array(
			'Qty_Refilled' => $quantityrefilled,
		
		)); // Will be logged 
			//throw new Exception('There was a problem inserting! ');

			echo false;

		
		}else
		{

			
			echo true;


		} 
	


?>