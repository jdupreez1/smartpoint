<?php

	require_once '../Core/init.php';

	$user = new user(null,$_log);
	$_db = db::getInstance();
	
	if(input::existsVal('userID')){
		$userid = input::get('userID');
	}else
	{
		$userid = $user->data()->Id;
	}

	if(input::existsVal('active')){
		$active = input::get('active');
	}


	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}

	


	$events = array();
	$singleEvent = array();
	
	


	$hospitalname = '';
	$doctorname = '';
	$equipemtrequired = '';
	$organiser = '';
	$date = '';
	$driver = '';
	
	if($active == 1 ){

		if($dbh = $_db->get('Event_Req', array('Organiser','=',$userid,'Operation_Date','>=',$_GET["start"],'Operation_Date','<=',$_GET["end"],'Status','=','closed'))){    //get data from event table. No where statement required
				if($dbh->counts() > 0){
					$i = 0;
					
					foreach($dbh->results() as $key)
					{	$delivered = 0;
						$fill = 1;
						
						/*if($key->Consignment == 1)
						{
							
							$delivered = 1;
						}else 
						{
							if($dbh2 = $_db->get('Event_Delivery', array('Event_Req_Id','=',$key->Id))){    //get data from event table. No where statement required
								if($dbh2->counts() > 0){
							
									$delivered = 1;
							
							
								}
								else
								{
									$delivered = 0;
								}
							}
						}*/

						/*if($dbh2 = $_db->get('Event_Collect', array('Event_Req_Id','=',$key->Id))){    //check whether item has been collected
							if($dbh2->counts() > 0){

								$fill = 1;
								

							}
							else
							{
								$fill = 0;
							}
						}
						if($dbh2 = $_db->get('Event_Usage', array('Event_Req_Id','=',$key->Id,'Qty_Refilled','>',0,'Qty_Used','=','Qty_Refilled'))){    //check whether item has been collected
							if($dbh2->counts() > 0){

								$fill = 1;
								

							}
							else
							{
								$fill = 0;
							}
						}

						/*$tobecollect = 0;
						if($dbh2 = $_db->get('Event_Usage', array('Event_Req_Id','=',$key->Id))){    //get data from event table. No where statement required
							if($dbh2->counts() > 0){

								$tobecollect = 1;
								

							}
							else
							{
								$tobecollect = 0;
							}
						}*/

						

						if($fill == 1 )
						{
							//$obj = new stdClass();
							$date = strtotime($key->Operation_Date); 
							//$date2 = strtotime($key->Delivery_Date); 
							
							//get organiser name from user ID
							if($dbh2 = $_db->get('Users', array('Id', '=', $key->Organiser))){    
								foreach($dbh2->results() as $key2){ 
									$organiser = $key2->Full_Name;
									
								}						
							}

							//get driver name from user ID
							if($dbh2 = $_db->get('Users', array('Id', '=', $key->Driver_Ack))){    
								if($dbh2->counts() > 0){
									foreach($dbh2->results() as $key2){ 
										$driver = $key2->Full_Name;
										
									}
								}else
								{
									$driver = 'None';
								}
							}


							//get hospital name from hospital ID
							if($dbh2 = $_db->get('Hospitals', array('Id', '=', $key->Hospital))){    
								foreach($dbh2->results() as $key2){ 
									$hospitalname = $key2->Name;
									
								}						
							}

							//get doctor name from doctor ID
							if($dbh2 = $_db->get('Doctors', array('Id', '=', $key->Doctor))){    
								foreach($dbh2->results() as $key2){ 
									$doctorname = $key2->Name;
									
								}						
							}

							//get equipment description name from equipment ID ID
							if($dbh2 = $_db->get('Equipment_Sets', array('Id', '=', $key->Equipment_Required))){    
								foreach($dbh2->results() as $key2){ 
									$equipmentrequired = $key2->Description;
									
								}						
							}
				
						//	$details = $hospitalname . ", " . $doctorname;
							//echo "<script type='text/javascript'> populateEventTable('$hospitalname','$doctorname','$key->Operation_Date','$equipemtrequired','$edit_button'); </script>";
							//$events = json_encode(array('title' => $organiser . " " . $doctorname));

							

							$consign = "no";
							if($key->Consignment == 1)
							{
								$consign = "Yes";
							}else 
							{
								$consign = "No";
							}

							$singleEvent = array(
							'id' =>  $key->Id,	
							'title' => $organiser . "\r\n" . $hospitalname . " - " . $doctorname . "\r\n" . "Equipment: " . $equipmentrequired . "\r\n" . "Rep Attend: " . $key->Rep_Attend . " / " . "Consignment: " . $consign, 
							'start' => date("Y-m-d H:i:s", $date),
							'driver_ack' => $driver,
							'hospital' => $hospitalname,
							'doctor' => $doctorname,
							'equipment' => $equipmentrequired,
							'repAttend' => $key->Rep_Attend,
							'consignment' => $consign,
							'organiser' => $organiser,
							'organiserID' => $key->Organiser,
							//'delivery' => date("Y-m-d H:i:s", $date2),
							'type' => "RepCollected",
							'comments' => $key->Comments,
							'status' => $key->Status
							
							);
							array_push($events, $singleEvent);
						}
					
					}
					
					echo  json_encode($events) ;
					
					

					
				}else
				{
					echo "Nothing found in DB";
				}

			}
			else {
				echo "Could not read from DB";
			}
		}



		



		/*$obj->title = "me" . " " . "me again";

					$obj->start = date("Y-m-dTH:i:s", time());
				
					$events = json_encode($obj);
					echo "[" . $events . "]";
*/

		//			echo '[{"title":"Lunch","allDay":"","id":"9","participants":"456","organizer":"36","propId":"14","reason":"to eet","start":"2015-04-27 11:00:00","end":"2015-04-27 11:30:00"},{"title":"dd","allDay":"","id":"15","participants":"45","organizer":"36","propId":"45","reason":"asdf","start":"2015-04-27 11:00:00","end":"2015-04-27 11:30:00"}]';



/*echo json_encode( array(
        array(
            'id' => 123,
            'title' => "myevent",
            'start' => "2015-04-27 10:05:00",
            'end' => "2015-04-27 11:55:00",
            'allDay' => false
         )
         //more events...
     ));
*/

?>