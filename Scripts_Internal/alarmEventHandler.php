<?php
	require_once '../Core/init.php';
		
	$_db = db::getInstance();
	$delay = 5;
	$last_alarm_id = 0;
	$last_fault_id = 0;
	$subject = "Vectrack Alert";
	
	$headers = 'From: Vectrack <mariusminny@gmail.com>' . "\r\n";

	//get highest Alarm_Event ID from database at startup
	if($data = $_db->get('Alarm_Event',array('Id','>','ANY')))
	{
		if($data->counts() > 0)
		{

			$last_alarm_id = $data->last()->Id;
			echo "Id = $last_alarm_id\n";

		}else
		{
			echo "no data received from database 1\n";
		}

	}else
	{
		echo "Could not read from DB 1\n";
	}
	//get highest Fault_Event ID from database at startup
	if($data = $_db->get('Fault_Event',array('Id','>','ANY')))
	{
		if($data->counts() > 0)
		{

			$last_fault_id = $data->last()->Id;
			echo "Id = $last_fault_id\n";

		}else
		{
			echo "no data received from database 1\n";
		}

	}else
	{
		echo "Could not read from DB 1\n";
	}

	do{

		//check for alarm events in DB
		$timenow = date('H:i:s');
		if($data2 = $_db->get('Alarm_Event',array('Id','>',$last_alarm_id)))
		{
			$message = "The following alarm event occured on:\n";
			if($data2->counts() > 0)
			{
				$last_alarm_id = $data->last()->Id;

				//echo "Id 2 = $last_alarm_id\n";

				foreach($data2->results() as $key)
				{
					if($email = getEmailAddress($_db,$key->Unit_Id))
					{
						$user = $email[0];
						$alarm = getValue(1,$key->Alarm_Type);
						
						$message = $message . "RTU: $email[1]\nAlarm Type: $alarm[0]\nAlarm Value: $key->Alarm_Value $alarm[1]\nTime: $timenow" ;
						
						if(checkTimes($_db,$user))
						{
							//echo "do email stuff\n";
							//var_dump($email);
							for($i = 2; $i < sizeof($email)  ; $i++)
							{	//echo $email[$i];



								mail( $email[$i] , $subject , $message, $headers );
							}

						}else
						{
							echo "do nothing\n";
						}

					}
				}

			}else
			{
				//echo "no data received from database\n";
			}

		}else
		{
			echo "Could not read from DB\n";
		}


		//check for fault events in DB
		if($data2 = $_db->get('Fault_Event',array('Id','>',$last_fault_id)))
		{
			$message = "The following fault event occured on:\n";
			if($data2->counts() > 0)
			{
				$last_fault_id = $data->last()->Id;

				//echo "Id 2 = $last_fault_id\n";

				foreach($data2->results() as $key)
				{
					if($email = getEmailAddress($_db,$key->Unit_Id))
					{
						$user = $email[0];
						$alarm = getValue(2,$key->Fault_Type);
						
						$message = $message . "RTU: $email[1]\nFault Type: $alarm[0]\nFault Value: $key->Fault_Value $alarm[1]\nTime: $timenow" ;
						
						if(checkTimes($_db,$user))
						{
							//echo "do email stuff\n";
							//var_dump($email);
							for($i = 2; $i < sizeof($email)  ; $i++)
							{	//echo $email[$i];



								mail( $email[$i] , $subject , $message, $headers );
							}

						}else
						{
							echo "do nothing\n";
						}

					}
				}

			}else
			{
				//echo "no data received from database\n";
			}

		}else
		{
			echo "Could not read from DB\n";
		}


		sleep($delay);

	}while(1);





function getEmailAddress($_db,$unitId){


	if($data2 = $_db->get('Units',array('Unit_Id','=',$unitId)))
	{
		if($data2->counts() > 0)
		{
			

			$data_db = $data2->first();
			$user = $data_db->User_Id;
			$secondaryMail = $data_db->Secondary_Email_Notification;
			$primaryMail = null;
			$RTUDescription = $data_db->Unit_Description;



			//var_dump($user);
			//var_dump($secondaryMail);


			if($data3 = $_db->get('Notification_Config',array('User_Id','=',$user)))
			{
				if($data3->counts() > 0)
				{
					

					$data2_db = $data3->first();
					$mailType = $data2_db->Primary_Email;
					

					if($mailType == 1 || $mailType == 2)
					{

						if($data4 = $_db->get('Users',array('Id','=',$user)))
						{
							if($data4->counts() > 0)
							{
								

								$data3_db = $data4->first();
								$primaryMail = $data3_db->Username;
							}else
							{
								echo "no data found in users table\n";
							}
						}else
						{
							echo "could not read from users database table\n";
						}

						if($mailType == 1)
						{
							return array($user,$RTUDescription,$primaryMail);
						}else
						{
							return array($user,$RTUDescription,$primaryMail,$secondaryMail);
						}
					

					}elseif($mailType == 0)
					{
						return array($user,$RTUDescription,$secondaryMail);
					}else
					{
						return array();
					}
					

				}
					

			}else
			{
				echo "no data received from notification config database\n";
			}
			

		}else
		{
			echo "no data received from units database\n";
		}


	}else
	{
		echo "Could not read from DB\n";
	}
	return;

}



function checkTimes($_db,$userId){

	if($data2 = $_db->get('Notification_Times',array('User_Id','=',$userId)))
	{
		if($data2->counts() > 0)
		{
			

			$data_db = $data2->first();
			date_default_timezone_set('Africa/Johannesburg');
			$start = null;
			$end = null;
			$dayofweek = (int)date('w', time());
			$saturday = 0;
			$sunday = 1;
			$friday = 6;
			
			//var_dump($dayofweek);

			if($dayofweek  > $sunday && $dayofweek  <= $friday)
			{

				//weekday
				$start = $data_db->Start_Time;
				$end = $data_db->End_Time;



			}elseif($dayofweek  == $sunday)
			{
				//sunday

				$start = $data_db->Sunday_Start_Time;
				$end = $data_db->Sunday_End_Time;



			}elseif($dayofweek  == $saturday)
			{
				//saturday
				$start = $data_db->Saturday_Start_Time;
				$end = $data_db->Saturday_End_Time;

			}

			//var_dump($start);
			//var_dump($end);
			$time = date('H:i:s');

			if(strtotime($time) >= strtotime($start) && strtotime($time) < strtotime($end))
			{
				return true;
			}else
			{
				return false;
			}


				return false;
			


		}else
		{
			echo "no data received from units database\n";
		}


	}else
	{
		echo "Could not read from DB\n";
	}

	return false;


}

function getValue($type, $Alarm_Type){
	$alarm = [] ;

	if($type == 1){
		switch ($Alarm_Type) {
			case '1':
				$alarm[0] = "Geo-Fence";
				$alarm[1] = null;
				break;
			case '2':
				$alarm[0] = "Speeding";
				$alarm[1] = "KM/H";
				break;
			case '3':
				$alarm[0] = "Stationary Time";
				$alarm[1] = "mins";
				break;
			case '4':
				$alarm[0] = "Excessive Distance Travel";
				$alarm[1] = "KM";
				break;
			case '5':
				$alarm[0] = "Fuel usage";
				$alarm[1] = 'litres';
				break;
			case '6':
				$alarm[0] = "Crash";
				$alarm[1] = null;
				break;
			case '7':
				$alarm[0] = "Softlock";
				$alarm[1] = null;
				break;
			case '8':
				$alarm[0] = "Driver_Needs_Rest";
				$alarm[1] = "mins";
				break;		
			default:
				$alarm[0] = null;
				$alarm[1] = null;
				
				break;

			
		}
	}elseif($type == 2){
		switch ($Alarm_Type) {
			case '1':
				$alarm[0] = "Battery Low";
				$alarm[1] = "V";
				break;
			case '2':
				$alarm[0] = "Position Data Lost";
				$alarm[1] = null;
				break;
			default:
				$alarm[0] = null;
				$alarm[1] = null;
				
				break;
		}

	}


	return $alarm;

}

?>