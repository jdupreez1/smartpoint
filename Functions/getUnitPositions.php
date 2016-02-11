<?php
	require_once '../Core/init.php';
		
	
		$_db = db::getInstance();

	$unit_id = $_POST["Unit_Id"];
	$start_Time = $_POST["start_Date"];
	$end_Time = $_POST["end_Date"];
	//echo $unit_id;
	if($data = $_db->get('Unit_Route_Data',array('Unit_Id','=',$unit_id,'Time','>',$start_Time . ' 00:00:01','Time','<',$end_Time . ' 23:59:59')))
	{
		echo json_encode($data->results());
	}else
	{
		$_log->warning("Could not get position data from DB");
	}
	
	

?>
