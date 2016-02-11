<?php

	require_once '../Core/init.php';
	
	
	$user = new user(null,$_log);
	$_db = db::getInstance();
	

	if(!$user->isLoggedIn()) {
		redirect::to('index.php');
	}	
 
	 
	$event = $_POST['Event'];
	
	

	 if($db_data = $_db->get('Event_Req',array('Id','=',$event)))   //extract the data for the RTU in DB
	{
			$user = array();
		if($db_data->counts() > 0) 
		{
			
			//var_dump($db_data2);
		  	$user["Id"] = $db_data->first()->Organiser;

			if($db_data2 = $_db->get('Users',array('Id','=',$user["Id"])))   //extract the data for the RTU in DB
			{
				
				if($db_data2->counts() > 0) 
				{
					
					//var_dump($db_data2);
				  
				  	$user["Name"] = $db_data2->first()->Full_Name;
					
					echo json_encode($user);
				}
				else
				{	
					echo false;
				}
			}else
			{
				
				echo false;//$this->e("Could not read from DB");
			}




		  echo false;
			
		}
		else
		{	
			echo false;
		}
	}else
	{
		
		echo false;//$this->e("Could not read from DB");
	}





?>