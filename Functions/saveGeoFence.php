<?php
	//ini_set('display_errors',1);  error_reporting(E_ALL);
	require_once '../Core/init.php';
	

	
	$user = new user(null,$_log);
	$_db = db::getInstance();
	
	//var_dump($logger);
	
	

	if(!$user->isLoggedIn()) {
		redirect::to('index.php');
	}	
 
	 $coordinates = $_POST['coordinates'];
	 $radius = $_POST['radius'];
	 $type = $_POST['type'];
	 $RTU_ID = $_POST['rtuID'];
	
	$fields = getFields($RTU_ID,$type,$radius,$coordinates);

	 if($db_data = $_db->get('Unit_Geo_Fences',array('Unit_Id','=',$RTU_ID)))   //extract the data for the RTU in DB
	{
			
		if($db_data->counts() > 0) 
		{
			 if(!$_db->updateUnit('Unit_Geo_Fences',$RTU_ID, $fields)) 
			{
				$_log->info('Could not update fence into DB', $fields); // Will be logged 
				throw new Exception('There was a problem updating! ');
				echo false;
			}
			 $_log->info('fence saved for RTU_ID: ' . $RTU_ID); // Will be logged 
			echo true;
		}
		else
		{	
			if(!$_db->insert('Unit_Geo_Fences', $fields)) 
			{
				$_log->error('Could not insert fence into DB', $fields); // Will be logged 
				throw new Exception('There was a problem inserting! ');

				echo false;;
			}
			echo true;
		}
	}else
	{
		echo false;//$this->e("Could not read from DB");
	}




	


function getFields($ID,$type,$radius,$coordinates){

	if($type == 0)  // circle
	{
		$fields = 	array(
		'Unit_Id' => $ID,
		'Fence_Nr' => 1,									
		'Fence_Type' => $type,
		'Radius' => (int)round($radius),
		'Coord_0_Lat' => round(floatval($coordinates[0]),6),
		'Coord_0_Long' => round(floatval($coordinates[1]),6)
		);	

		for($i = 1;$i < 100; $i++ )
		{
			$fields['Coord_'.$i.'_Lat'] =  floatval(0);
			$fields['Coord_'.$i.'_Long'] =  floatval(0);
		}

		//var_dump($fields);
		return $fields;

	}elseif ($type == 1)    //polygon
	{
		$fields = 	array(
		'Unit_Id' => $ID,	
		'Fence_Nr' => 1,									
		'Fence_Type' => $type,
		'Radius' => $radius
		
		);	
		
		for($i = 0;$i < 100; $i++ )
		{
		
			if($i < sizeof($coordinates))
			{
				$fields['Coord_'.$i.'_Lat'] = round(floatval($coordinates[$i][0]),6);
				$fields['Coord_'.$i.'_Long'] = round(floatval($coordinates[$i][1]),6);
			}else
			{
				$fields['Coord_'.$i.'_Lat'] = floatval(0);
				$fields['Coord_'.$i.'_Long'] =  floatval(0);
			}

		}
		
			
		return $fields;	

	}
	
}




?>