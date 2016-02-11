<?php

require_once '../Core/init.php';
//require_once '../Scripts/twitter.class.php';
// ENTER HERE YOUR CREDENTIALS (see readme.txt)
$user = new user(null,$_log);
$_db = db::getInstance();

if(!$user->isLoggedIn()) {
	redirect::to('../index.php');
}

$page = $_POST["Page"];
$eventid = $_POST["Eventid"];

switch ($page) {
	case 'Calender':
	case 'Home':
			$query = "Select
		 	a3.Full_Name 'Delivered By', 
		 	Event_Req.TIMESTAMPREC 'Event Logged',
		 	Event_Delivery.Set_Serial 'Set Serial',
		 	Event_Delivery.CSSD_Name 'CSSD Name',
		 	Event_Delivery.Timestamp 'Delivery Time',
			Event_Delivery.TIMESTAMPREC 'Delivery Logged',
			Event_Patient.Patient_Name 'Patient Name',
			Event_Patient.Patient_Nr 'Patient Nr',
			Event_Patient.Order_Nr 'Order Nr',
			Set_Spares.Description 'Used Description',
			Event_Usage.QTY_Used 'Amount Used',
			a4.Full_Name 'Collected By', 
			Event_Collect.Timestamp 'Collection Time', 
			Event_Collect.Used, 
			Event_Collect.TIMESTAMPREC 'Collection Logged',
			Event_Usage.TIMESTAMPREC 'Usage Logged',
			Event_Invoice.Invoiced_By 'Invoiced By',
			Event_Invoice.Invoice_Number 'Invoice Number',
			Event_Invoice.Invoice_Amount 'Invoice Amount',
			Event_Invoice.Timestamp 'Date Invoiced',
			Event_Invoice.TIMESTAMPREC 'Invoice Logged'
			FROM Event_Req 
			  LEFT JOIN Doctors ON Doctors.Id = Event_Req.Doctor
			  LEFT JOIN Hospitals ON Hospitals.Id = Event_Req.Hospital
			  LEFT JOIN Equipment_Sets ON Equipment_Sets.Id = Event_Req.Equipment_Required 
			  LEFT JOIN Users a1 ON a1.Id = Event_Req.Organiser
			  LEFT JOIN Users a2 ON a2.Id = Event_Req.Driver_Ack
			  LEFT JOIN Event_Delivery ON Event_Delivery.Event_Req_Id = Event_Req.Id
			  LEFT JOIN Event_Usage ON Event_Usage.Event_Req_Id = Event_Req.Id
			  LEFT JOIN Event_Patient ON Event_Patient.Event_Req_Id = Event_Req.Id 
			  LEFT JOIN Set_Spares ON Set_Spares.Stock_Code = Event_Usage.Stock_Code
			  LEFT JOIN Event_Collect ON Event_Collect.Event_Req_Id = Event_Req.Id
			  LEFT JOIN Event_Invoice ON Event_Invoice.Event_Req_Id = Event_Req.Id
			  LEFT JOIN Users a3 ON a3.Id = Event_Delivery.Delivered_By
			  LEFT JOIN Users a4 ON a4.Id = Event_Collect.Collected_By
			WHERE Event_Req.Id = " . $eventid . " ORDER BY Event_Patient.Id DESC;";
	break;

	case 'deliveryUpdate':
			$query = "Select
		 	Users.Full_Name 'Full Name',
		 	Equipment_Sets.Description 'Equipment Description',
		 	Event_Req.Comments 'Event Comments'
			FROM Event_Req 
			  LEFT JOIN Doctors ON Doctors.Id = Event_Req.Doctor
			  LEFT JOIN Hospitals ON Hospitals.Id = Event_Req.Hospital
			  LEFT JOIN Equipment_Sets ON Equipment_Sets.Id = Event_Req.Equipment_Required 
			  LEFT JOIN Users ON Users.Id = Event_Req.Organiser		
			  LEFT JOIN Event_Delivery ON Event_Delivery.Event_Req_Id = Event_Req.Id
			  LEFT JOIN Event_Usage ON Event_Usage.Event_Req_Id = Event_Req.Id
			  LEFT JOIN Event_Patient ON Event_Patient.Event_Req_Id = Event_Req.Id 
			  LEFT JOIN Set_Spares ON Set_Spares.Stock_Code = Event_Usage.Stock_Code
			  LEFT JOIN Event_Collect ON Event_Collect.Event_Req_Id = Event_Req.Id
			  LEFT JOIN Event_Invoice ON Event_Invoice.Event_Req_Id = Event_Req.Id
			WHERE Event_Req.Id = " . $eventid . " ORDER BY Event_Patient.Id DESC;";
	break;

	
	



	// default:
	// 	# code...
	// 	break;
}

$dbh = $_db->query($query, array(999));
	
$data = $dbh->results();
echo json_encode($data);

?>


