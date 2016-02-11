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
	
	


	$eventid = $_POST["Eventid"];
	

	if($dbh = $_db->get('Event_Req', array("Id","=",$eventid))){    
		
		

		if($dbh->counts() > 0){
			foreach($dbh->results() as $key){
				//echo $key->Status;
				$array[0] = $key->Status;			
				echo json_encode($array); 				

			}
		}

	}

?>