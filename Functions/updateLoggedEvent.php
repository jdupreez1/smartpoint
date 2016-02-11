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
	$id = $_POST['Id'];
	$organiser = $_POST['Organiser'];
	$hospital = $_POST['Hospital'];
	$doctor = $_POST['Doctor']; 
	$deliverydate = $_POST['Deliverydate'];
	$operationdate = $_POST['Operationdate'];
	$operationtime = $_POST['Operationtime']; 
	$equipmenttodeliver = $_POST['Equipmenttodeliver'];
	$deliverytypetext = $_POST['Deliverytypetext'];
	$repattendance = $_POST['Repattendance']; 
	$additionalnotes = $_POST['Additionalnotes'];
	$driverack = NULL;

	//get organiser ID from organiser name
    if($dbh = $_db->get('Users', array('Username','=',$organiser))){
		if($dbh->counts() > 0){
			foreach ($dbh->results() as $key) {
				$organiserid = $key->Id;
			}
		}
	}
	//get hospital ID from hospital name
    if($dbh = $_db->get('Hospitals', array('Name','=',$hospital))){
		if($dbh->counts() > 0){
			foreach ($dbh->results() as $key) {
				$hospitalid = $key->Id;
			}
		}
	}
	//get doctor ID from doctor name
    if($dbh = $_db->get('Doctors', array('Name','=',$doctor))){
		if($dbh->counts() > 0){
			foreach ($dbh->results() as $key) {
				$doctorid = $key->Id;
			}
		}
	}
	//get equipment ID from equipment name
    if($dbh = $_db->get('Equipment_Sets', array('Description','=',$equipmenttodeliver))){
		if($dbh->counts() > 0){
			foreach ($dbh->results() as $key) {
				$equipmentid = $key->Id;
			}
		}
	}

	//get delivery type value from delivery type text 
	if ($deliverytypetext == "Consignment" ) {
		$deliverytypevalue = 1;
	} else 
		$deliverytypevalue = 0;

	$operationDateAndTime = $operationdate . " " . $operationtime;

	if(!$_db->update('Event_Req', $id ,array(
		// 'Id' => '',
		'Organiser' => $organiserid,
		'Hospital' => $hospitalid,
		'Doctor' => $doctorid,
		'Delivery_Date' => $deliverydate,
		'Operation_Date' => $operationDateAndTime,
		'Equipment_Required' => $equipmentid,
		'Consignment' => $deliverytypevalue,
		'Rep_Attend' => $repattendance,
		'Comments' => $additionalnotes,
		'Driver_Ack' => $driverack
		))) 
		
		{
			$_log->error('Could not insert new event into DB', array('Id' => '',
		'Organiser' => $organiserid,
		'Hospital' => $hospitalid,
		'Doctor' => $doctorid,
		'Delivery_Date' => $deliverydate,
		'Operation_Date' => $operationDateAndTime,
		'Equipment_Required' => $equipmentid,
		'Consignment' => $deliverytypevalue,
		'Rep_Attend' => $repattendance,
		'Comments' => $additionalnotes,
		'Driver_Ack' => $driverack)); // Will be logged 
			throw new Exception('There was a problem inserting! ');

			echo false;

		
		}else
		{

			
			echo true;


		} 
	


?>