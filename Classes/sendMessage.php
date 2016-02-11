<?php

 class sendMessage{


 	private $_db,
		$_data,
		$_eventCreated = array(),
		$_eventDeleted = array(),
		$_eventUpdated = array(),
		$_eventAcked = array(),
		$_eventUnacked = array(),
		$_eventDelivered = array(),
		$_eventPatient = array(),
		$_eventUsages = array(),
		$_eventCollected = array();
	private  $_events = array();
		


			
		

		public function __construct()
		{	$events = array();
			$eventSingle = array();
			$this->_db = db::getInstance();
			if($db_data = $this->_db->get('Company_Notification_Config',array()))   //extract the data for the RTU in DB
			{
					
				if($db_data->counts() > 0) 
				{

					foreach ($db_data->results() as $key => $value) {
						
						foreach($value as $key2 => $value2) {
				
							
							$eventSingle[$key2] = $value2;
							
							
						}

						$events[$eventSingle['Event_Type']] = $eventSingle;


					}
					$this->_events = $events;
					//echo $events;
				}
				
				else
				{	
					echo "no data found in Notification_Config table";
				}


			}else
			{
				$this->e("Could not read from DB");
			}
		}



		 function printMessage(){
			//var_dump($this->_events);
		}	
			

 	
	public  function send($type,$data,$user){

			$result = $this->_events;
			//var_dump($result);
			//var_dump($type);
			//var_dump($data);
			//var_dump($result[$type]['Email']);

			//$userdata = array();
			$success = 1;
			if($type == "Instant"){

				$userdata = array();
				$userdata = $this->getUsers(8,$user);
				//foreach ($userdata as $key => $value) {
				//		$success =  $this->sendPush($data,$value['Push_Id']);
				//	}
				$success = $this->sendPush($data,$userdata[0]['Push_Id']);
			

			}elseif($result[$type]['Email'] == 1)    //send email
			{

				if($result[$type]['Originator'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(0,$user);
					
					 $success = $this->sendEmail($data,$userdata[0]['Username']);

				}


				if($result[$type]['Driver'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(6,$user);
					foreach ($userdata as $key => $value) {
						 $success = $this->sendEmail($data,$value['Username']);
					}
				}

				if($result[$type]['Rep'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(5,$user);
					foreach ($userdata as $key => $value) {
						$success =  $this->sendEmail($data,$value['Username']);
					}
				}

				if($result[$type]['Admin'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(2,$user);
					foreach ($userdata as $key => $value) {
					 $success = $this->sendEmail($data,$value['Username']);
					}
				}

				if($result[$type]['Manager'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(4,$user);
					foreach ($userdata as $key => $value) {
						$success =  $this->sendEmail($data,$value['Username']);
					}
				}

				if($result[$type]['Finances'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(3,$user);
					foreach ($userdata as $key => $value) {
					 $success = $this->sendEmail($data,$value['Username']);
					}
				}

				if($result[$type]['Guest'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(7,$user);
					foreach ($userdata as $key => $value) {
				 		$success = $this->sendEmail($data,$value['Username']);
				 	}
				}

			}elseif ($result[$type]['Tweet'] == 1) {    //send tweet
				# code...


			}elseif ($result[$type]['Push'] == 1) {     //send push
				if($result[$type]['Originator'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(0,$user);
					
					 $success = $this->sendPush($data,$userdata[0]['Push_Id']);

				}


				if($result[$type]['Driver'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(6,$user);
					//var_dump($userdata);
					foreach ($userdata as $key => $value) {
						  $success = $this->sendPush($data,$value['Push_Id']);
					}
				}

				if($result[$type]['Rep'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(5,$user);
					foreach ($userdata as $key => $value) {
					 $success = $this->sendPush($data,$value['Push_Id']);
					}
				}

				if($result[$type]['Admin'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(2,$user);
					foreach ($userdata as $key => $value) {
					  $success = $this->sendPush($data,$value['Push_Id']);
					}
				}

				if($result[$type]['Manager'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(3,$user);
					foreach ($userdata as $key => $value) {
					 $success = $this->sendPush($data,$value['Push_Id']);
					}
				}

				if($result[$type]['Finances'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(4,$user);
					foreach ($userdata as $key => $value) {
					 $success = $this->sendPush($data,$value['Push_Id']);
					}
				}

				if($result[$type]['Guest'] == 1){
					$userdata = array();
					$userdata = $this->getUsers(7,$user);
					foreach ($userdata as $key => $value) {
				 	 $success = $this->sendPush($data,$value['Push_Id']);
				 	}
				}

			}

			return $success;
 			
 		
 	}

	
 	private function getUsers($type,$user){
		$db_data = '';
		
 		if($type == 0){
 			$db_data = $this->_db->get('Users',array('Id','=',$user));
 		}elseif($type == 8){
 			$db_data = $this->_db->get('Users',array('Username','=',$user));
 		
 		}else
 		{
 			$db_data = $this->_db->get('Users',array('User_Group','=',$type));
 		}
 		if($db_data)   //extract the data for the RTU in DB
			{
					$users = array();
				if($db_data->counts() > 0) 
				{
					$i = 0;
					foreach ($db_data->results() as $key) {
						
						$users[$i]['Username'] = $key->Username;
						$users[$i]['Push_Id'] = $key->Push_Id;
						$i++;
						}
					
						return $users;
				}
				
				else
				{	
					return false;
				}


			}else
			{
				return false;
			}


 	}

 	public function sendEmail($data,$username){

 		
			
			

			$subject = "Orchestrate Email Notification";
		
			$headers = 'From: Orchestrate <mariusminny@gmail.com>' . "\r\n";

			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
						
			
			$message2 = '
			<html>
			
			<body>
				<p>'. $data .'</p>
				</br>
				<a href="http://orchestrate.co.za">Open Webpage </a>
			</body>
			</html>
			';
								
								


			mail($username , $subject , $message2, $headers );
		


 	}

 	public function sendPush($data,$username){
 		if($username){

 		curl_setopt_array($ch = curl_init(), array(
		  CURLOPT_URL => "https://api.pushover.net/1/messages.json",
		  CURLOPT_POSTFIELDS => array(
		    "token" => "aY1LCn9N42G7XVWWBQoYhfnqfDWN21",
		    "user" => $username,
		    "html" => 1,
		    "message" => $data . " " . "<a href='http://orchestrate.co.za'>Open Webpage </a>",
		  ),
		  CURLOPT_SAFE_UPLOAD => true,
		));
		curl_exec($ch);
		curl_close($ch);

 	}
 }

 }

// $obj = new sendMessage();

// $obj->printMessage();
?>
