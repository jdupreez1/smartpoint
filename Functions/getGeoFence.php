<?php

	require_once '../Core/init.php';
	
	
	$user = new user(null,$_log);
	$_db = db::getInstance();
	

	if(!$user->isLoggedIn()) {
		redirect::to('index.php');
	}	
 
	 
	$RTU_ID = $_POST['rtuID'];
	
	

	 if($db_data = $_db->get('Unit_Geo_Fences',array('Unit_Id','=',$RTU_ID)))   //extract the data for the RTU in DB
	{
			
		if($db_data->counts() > 0) 
		{
			$db_data2 = $db_data->first();
			//var_dump($db_data2);
		  
			echo json_encode($db_data2);
			
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