<?php

require_once '../Core/init.php';
//require_once '../Scripts/twitter.class.php';
// ENTER HERE YOUR CREDENTIALS (see readme.txt)
$user = new user(null,$_log);
$_db = db::getInstance();

if(!$user->isLoggedIn()) {
	redirect::to('../index.php');
}

//echo($t . "<br>");
//echo(date("Y-m-d",$t));

if($_POST['Type'] == "Time"){
	//$dbh = $_db->countIdDate("Event_Req");
	$dbh = $_db->query('Select DATE(Operation_Date) "Date",COUNT(Event_Req.Id) totalCount FROM Event_Req WHERE Event_Req.Operation_Date >= ? AND Event_Req.Operation_Date <= ?  GROUP BY DATE(Operation_Date)   ', array($_POST['Start']. ' 00:00:00',$_POST['End'] . ' 23:59:59'));
}elseif($_POST['Type'] == "Status")
{
	$dbh = $_db->query('Select Event_Req.Status "Name",COUNT(Event_Req.Status) totalCount FROM Event_Req WHERE Event_Req.Operation_Date >= ? AND Event_Req.Operation_Date <= ?  GROUP BY Name   ', array($_POST['Start']. ' 00:00:00',$_POST['End'] . ' 23:59:59'));
}elseif($_POST['Type'] == "Doctor")
{
	$dbh = $_db->query('Select Doctors.Name "Name",COUNT(Event_Req.Doctor) totalCount FROM Event_Req Inner Join
				 Doctors ON Doctors.Id = Event_Req.Doctor WHERE Event_Req.Operation_Date >= ? AND Event_Req.Operation_Date <= ?  GROUP BY Name   ', array($_POST['Start']. ' 00:00:00',$_POST['End'] . ' 23:59:59'));
}elseif($_POST['Type'] == "Rep")
{
	$dbh = $_db->query('Select Users.Full_Name "Name",COUNT(Event_Req.Organiser) totalCount FROM Event_Req Inner Join
				 Users ON Users.Id = Event_Req.Organiser WHERE Event_Req.Operation_Date >= ? AND Event_Req.Operation_Date <= ?  GROUP BY Name   ', array($_POST['Start']. ' 00:00:00',$_POST['End'] . ' 23:59:59'));
}elseif($_POST['Type'] == "Driver")
{
	$dbh = $_db->query('Select Users.Full_Name "Name",COUNT(Event_Req.Driver_Ack) totalCount FROM Event_Req Inner Join
				 Users ON Users.Id = Event_Req.Driver_Ack WHERE Event_Req.Operation_Date >= ? AND Event_Req.Operation_Date <= ?  GROUP BY Name   ', array($_POST['Start']. ' 00:00:00',$_POST['End'] . ' 23:59:59'));
}elseif($_POST['Type'] == "Hospital")
{
	$dbh = $_db->query('Select Hospitals.Name "Name",COUNT(Event_Req.Hospital) totalCount FROM Event_Req Inner Join
				 Hospitals ON Hospitals.Id = Event_Req.Hospital WHERE Event_Req.Operation_Date >= ? AND Event_Req.Operation_Date <= ?  GROUP BY Name   ', array($_POST['Start']. ' 00:00:00',$_POST['End'] . ' 23:59:59'));
}elseif($_POST['Type'] == "Usage")
{
	$dbh = $_db->query('Select Equipment_Sets.Description "Name",COUNT(Event_Req.Equipment_Required) totalCount FROM Event_Req Inner Join
				 Equipment_Sets ON Equipment_Sets.Id = Event_Req.Equipment_Required WHERE Event_Req.Operation_Date >= ? AND Event_Req.Operation_Date <= ?  GROUP BY Name   ', array($_POST['Start']. ' 00:00:00',$_POST['End'] . ' 23:59:59'));
}elseif($_POST['Type'] == "Report1") {

	//$dbh = $_db->getinnerjoin2("Event_Req.Organiser, Event_Delivery.Delivered_By","Event_Req","Event_Delivery","Event_Req.Id","Event_Delivery.Event_Req_Id",array("Event_Req.Id",'=',102));
/*$dbh = $_db->query("Select Event_Req.Organiser, Event_Req.Hospital, Event_Req.Doctor, Event_Req.Operation_Date, Event_Req.Equipment_Required 
	, Event_Req.Rep_Attend, , Event_Req.Status, Event_Req.TIMESTAMPREC, Event_Req.Driver_Ack, Event_Delivery.Delivered_By, Event_Delivery.Timestamp,
	 Event_Delivery.TIMESTAMPREC, Event_Collect.Collected_By, Event_Collect.Timestamp, Event_Collect.Used, Event_Collect.TIMESTAMPREC FROM Event_Req LEFT JOIN
	  (Doctors,Hospitals,Equipment_Sets,Users,Event_Delivery,Event_Collect) ON 
	  (Doctors.Id = Event_Req.Doctor  AND Hospitals.Id = Event_Req.Hospital AND Equipment_Sets.Id = Event_Req.Equipment_Required AND Users.Id = Event_Req.Driver_Ack
	  AND Event_Delivery.Event_Req_Id = Event_Req.Id  AND Event_Collect.Event_Req_Id = Event_Req.Id  ) WHERE Event_Req.Id = ?",array(102));
*/

if($_POST['Chart'] == 'None' && $_POST['Filter'] == 'none'){
	$where = 'Event_Req.Id < ';
	$param = array(999999,$_POST['Start'] . ' 00:00:00',$_POST['End'] . ' 23:59:59');

}elseif($_POST['Chart'] == 'Time'){
	$where = 'Event_Req.Operation_Date LIKE ';
	$param =  array($_POST['Filter'].'%',$_POST['Start'] . ' 00:00:00',$_POST['End'] . ' 23:59:59');

}elseif($_POST['Chart'] == 'Status'){

	$where = 'Event_Req.Status = ';
	$param = array($_POST['Filter'],$_POST['Start'] . ' 00:00:00',$_POST['End'] . ' 23:59:59');

}elseif($_POST['Chart'] == 'Usage'){
	$where = 'Equipment_Sets.Description = ';
	$param = array($_POST['Filter'],$_POST['Start'] . ' 00:00:00',$_POST['End'] . ' 23:59:59');

}elseif($_POST['Chart'] == 'Doctor'){
	$where = 'Doctors.Name = ';
	$param = array($_POST['Filter'],$_POST['Start'] . ' 00:00:00',$_POST['End'] . ' 23:59:59');

}elseif($_POST['Chart'] == 'Hospital'){
	$where = 'Hospitals.Name = ';
	$param = array($_POST['Filter'],$_POST['Start'] . ' 00:00:00',$_POST['End'] . ' 23:59:59');

}elseif($_POST['Chart'] == 'Rep'){
	$where = 'a1.Full_Name = ';
	$param = array($_POST['Filter'],$_POST['Start'] . ' 00:00:00',$_POST['End'] . ' 23:59:59');

}elseif($_POST['Chart'] == 'Driver'){
	$where = 'a2.Full_Name = ';
	$param = array($_POST['Filter'],$_POST['Start'] . ' 00:00:00',$_POST['End'] . ' 23:59:59');

}





$dbh = $_db->query("

	Select a1.Full_Name Originator,
	a2.Full_Name 'Acked By', 
	Hospitals.Name Hospital, 
	Doctors.Name Doctor, 
	Event_Req.Operation_Date 'Operation Date', 
	Equipment_Sets.Description 'Equipment', 
	Event_Req.Rep_Attend 'Rep Attend',
 	Event_Req.Status 'Event Status', 
 	Event_Req.TIMESTAMPREC 'Event Logged', 
 	a3.Full_Name 'Delivered By', 
 	Event_Delivery.Timestamp 'Delivery Time',
	Event_Delivery.TIMESTAMPREC 'Delivery Logged', 
	a4.Full_Name 'Collected By', 
	Event_Collect.Timestamp 'Collection Time', 
	Event_Collect.Used, 
	Event_Collect.TIMESTAMPREC 'Collection Logged'

	  FROM Event_Req 
	  LEFT JOIN Doctors ON Doctors.Id = Event_Req.Doctor
	  LEFT JOIN Hospitals ON Hospitals.Id = Event_Req.Hospital
	  LEFT JOIN Equipment_Sets ON Equipment_Sets.Id = Event_Req.Equipment_Required 
	  LEFT JOIN Users a1 ON a1.Id = Event_Req.Organiser
	  LEFT JOIN Users a2 ON a2.Id = Event_Req.Driver_Ack
	  LEFT JOIN Event_Delivery ON Event_Delivery.Event_Req_Id = Event_Req.Id
	  LEFT JOIN Event_Collect ON Event_Collect.Event_Req_Id = Event_Req.Id
	  LEFT JOIN Users a3 ON a3.Id = Event_Delivery.Delivered_By
	  LEFT JOIN Users a4 ON a4.Id = Event_Collect.Collected_By
	WHERE {$where} ? AND Event_Req.Operation_Date >= ? AND Event_Req.Operation_Date <= ? ",$param);

	    
	  	
	
	$data = $dbh->results();
	echo json_encode($data);

	# code...
}




if($dbh && $_POST['Type'] != "Report1"){    //get data from event table. No where statement required
	if($dbh->counts() > 0){
		$data = array();
		$i = 0;
		foreach($dbh->results() as $key => $value ){

			
				$data[$key] = $value;

			

			
			

		}
		
		echo json_encode($data);

	}
	else
	{
		return false;
	}
}else
{
	return false;
}


?>


