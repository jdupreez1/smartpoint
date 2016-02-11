<?php

require_once '../Core/init.php';
//require_once '../Scripts/twitter.class.php';
// ENTER HERE YOUR CREDENTIALS (see readme.txt)
$user = new user(null,$_log);
$_db = db::getInstance();

if(!$user->isLoggedIn()) {
	redirect::to('../index.php');
}

$eventstatus = $_POST["EventStatus"];

switch ($eventstatus) {
	
	case 'acked':
	$query = "Select
		Event_Req.Id 'Event Id',
		Users.Full_Name 'Organiser',
		Hospitals.Name 'Hospital',
		Doctors.Name 'Doctor',
		Event_Req.Operation_Date 'Operation Date'
		FROM Event_Req 
		LEFT JOIN Doctors ON Doctors.Id = Event_Req.Doctor
		LEFT JOIN Hospitals ON Hospitals.Id = Event_Req.Hospital
		LEFT JOIN Users ON Users.Id = Event_Req.Organiser
		WHERE Event_Req.Status = 'acked';";	
	break;

	// default:
	// 	# code...
	// 	break;
}

$dbh = $_db->query($query, array(999));
	
$data = $dbh->results();
echo json_encode($data);

?>


