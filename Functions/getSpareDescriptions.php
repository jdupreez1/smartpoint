<?php
	//ini_set('display_errors',1);  error_reporting(E_ALL);
	require_once '../Core/init.php';
	

	
	$user = new user(null,$_log);
	$_db = db::getInstance();
	
	//var_dump($logger);
	
	

	if(!$user->isLoggedIn()) {
		redirect::to('index.php');
	}	
 	
	$spareid = $_POST['Spareid'];

 	if($dbh = $_db->get('Set_Spares', array("Id","=",$spareid))){    
		
		

		if($dbh->counts() > 0){
			foreach($dbh->results() as $key){
				$array[0] = $key->Stock_Code;
				$array[1] = $key->Description;
				echo json_encode($array); 

			}
		}
	}
	
	 
		
	


?>