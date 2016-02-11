<?php
	//require_once '../Core/init.php';
	$debug = true;
	


	class comms{
		private $_db,
		$_data;
				
				


		public function __construct()
		{
			$this->_db = db::getInstance();
		}
		
		public function unPack($packet, $rxsocket, $remote_ip , $remote_port, $authok)
		{
			
			$data = unpack("H*",$packet);  												//unpack the binary data
			//e("two");
			//var_dump($data[1]);
			$hex = $this->strToHex($data[1]);											//convert into array of hex data
			$seq = hexdec($hex[3]);														//packet seq nr
			if($this->crc_calc($this->hexToStr($hex)) == 0)								//check crc is correct
			{

				if($hex[0] == "0x7E")
				{													//look for start byte indicator else send nack
					if($authok || $hex[7] == '0x49' || $hex[7] == '0x00' || $hex[7] == '0x01' || $hex[7] == '0x02' || $hex[7] == '0x48')   // chack that unit is authenticated or sending general command
					{
						$length = $this->getLength($hex[1],$hex[2]); 						// get length of data
						
						$RTU_ID = $this->getRTUID($hex[4],$hex[5],$hex[6]);     			//RTU ID

						if($db_data = $this->_db->get('Units',array('Serial_Nr','=',$RTU_ID)))   //extract the data for the RTU in DB
						{
								
							if($db_data->counts() > 0) 
							{
								$_data = $db_data->first();
							}
							else
							{	$this->e("Unknown RTU ID");
								$this->Pack($seq, "NAck","Unknown_ID",null, $rxsocket, $remote_ip , $remote_port);    //if no data in DB then RTU not found
							}
						}else
						{
							$this->e("Could not read from DB");
						}

						switch ($hex[7]) {													//determine which command is sent
							case '0x00':
								$this->e("Ack received");
								$this->Pack($seq, "Ack","Command_Ack",null, $rxsocket, $remote_ip , $remote_port);
								return 'Ack/$seq';
							break;
							case '0x01':
								$this->e("Nack received");
								$this->Pack($seq, "NAck","Unknown_Error",null, $rxsocket, $remote_ip , $remote_port);
								return 'NAck/$seq';


							break;

							case '0x02':
								$this->e("Ping Request");

								$this->Pack($seq, "Ack","Command_Ack",null, $rxsocket, $remote_ip , $remote_port);
							break;

							case '0x48':
								$this->e("Connection request received");
								$this->Pack($seq, "Ack","Key_Req",null, $rxsocket, $remote_ip , $remote_port);
							break;

							case '0x49':
								$this->e("Auth key received");

								$datarx = $this->getdata($hex,8);							//get data extracted from the received packet into an array

								
								if($this->strIntToHexCompare($_data->RTU_Auth_Key,$datarx))			//compare key in DB with received key
								{
									
									$this->e('Key OK');
									$this->Pack($seq, "Ack","Auth_Ack",null, $rxsocket, $remote_ip , $remote_port);   //if ok send Auth Ack
									return 'AuthOK';
								}
								else
								{
									
									$this->e('Key NOT OK');
									$this->Pack($seq, "NAck","Incorrect_Auth_Key",null, $rxsocket, $remote_ip , $remote_port);   //if not ok send auth nack
								}

							break;

							case '0x50':
								$this->e("Status reply received");

								$datarx = $this->getdata($hex,8);							//get data extracted from the received packet into an array

								if($datarx)
								{
									$fields = array(
										
										'Batt_Level' => hexdec($datarx[0]),
										'Power_Src' => hexdec($datarx[1]),
										'Ignition' => hexdec($datarx[2]),
										'Odometer' => hexdec($datarx[3]) << 16 | hexdec($datarx[4]) << 8 | hexdec($datarx[5]),
										'Distance_Traveled' => hexdec($datarx[6]) << 8 | hexdec($datarx[7]),
										'Stationary_Time' => hexdec($datarx[8]) << 8 | hexdec($datarx[9]), 
										'Fuel_Level' => hexdec($datarx[10]) << 8 | hexdec($datarx[11]),
										'Soft_Lock' => hexdec($datarx[12]),
										//'Current_Lat' => $this->hexTo32Float(hexdec($datarx[13]) << 32 | hexdec($datarx[14]) << 16 | hexdec($datarx[15]) << 8 | hexdec($datarx[16])) ,
										//'Current_Long' => $this->hexTo32Float(hexdec($datarx[17]) << 32 | hexdec($datarx[18]) << 16 | hexdec($datarx[19]) << 8 | hexdec($datarx[20])) ,
										//'Current_Speed' => hexdec($datarx[21]),
										'Timestamp' => date('Y-m-d H:i:s',time())
										
										
									);

									var_dump($datarx);

									if(!$this->_db->updateUnit('Unit_Status',$RTU_ID, $fields)) 
									{
										throw new Exception('There was a problem updating! ');
									}

									$this->Pack($seq, "Ack","Command_Ack",null, $rxsocket, $remote_ip , $remote_port);
								}else
								{
									$this->Pack($seq, "Nack","Value_Out_Bounds",null, $rxsocket, $remote_ip , $remote_port);
								}


									

								
							break;
							case '0x51':
								$this->e("Alarm_Status reply received");

								$datarx = $this->getdata($hex,8);							//get data extracted from the received packet into an array

								if($datarx)
								{
									$fields = array(
										
										'Geo_Fence' => hexdec($datarx[0]),
										'Speeding' => hexdec($datarx[1]),
										'Stationary_Time' =>  hexdec($datarx[2]) << 8 | hexdec($datarx[3]),
										'Excess_Distance' =>  hexdec($datarx[4]) << 8 | hexdec($datarx[5]),
										'Excess_Fuel' =>  hexdec($datarx[6]) << 8 | hexdec($datarx[7]),
										'Crash' => hexdec($datarx[8]),
										'Soft_Lock' => hexdec($datarx[9]),
										'Driver_Rest' =>  hexdec($datarx[10]) << 8 | hexdec($datarx[11])
																	
									);

									var_dump($datarx);

									if(!$this->_db->updateUnit('Unit_Alarm_Setup',$RTU_ID, $fields)) 
									{
										throw new Exception('There was a problem updating! ');
									}

									$this->Pack($seq, "Ack","Command_Ack",null, $rxsocket, $remote_ip , $remote_port);
								}else
								{
									$this->Pack($seq, "Nack","Value_Out_Bounds",null, $rxsocket, $remote_ip , $remote_port);
								}
										//do stuff

							break;
							case '0x52':
								$this->e("FW_Status reply received");

								$datarx = $this->getdata($hex,8);							//get data extracted from the received packet into an array

								if($datarx){
									$this->e("Firmware version on $RTU_ID = $datarx[0] $datarx[1] $datarx[2] $datarx[3]");

									$this->Pack($seq, "Ack","Command_Ack",null, $rxsocket, $remote_ip , $remote_port);         //////////////////////////////////do something here
								}else
								{
									$this->Pack($seq, "Nack","Value_Out_Bounds",null, $rxsocket, $remote_ip , $remote_port);
								}


								
							break;
							case '0x53':
								$this->e("Position / Speed received");

									$datarx = $this->getdata($hex,8);							//get data extracted from the received packet into an array

								if($datarx)
								{
									$fields = array(
										'Unit_Id' => $RTU_ID,
										'Lat' => $this->hexTo32Float(hexdec($datarx[0]) << 32 | hexdec($datarx[1]) << 16 | hexdec($datarx[2]) << 8 | hexdec($datarx[3])) ,
										'Lon' => $this->hexTo32Float(hexdec($datarx[4]) << 32 | hexdec($datarx[5]) << 16 | hexdec($datarx[6]) << 8 | hexdec($datarx[7])) ,
										'Speed' => hexdec($datarx[8]),
										'Time' => date('Y-m-d H:i:s',time())
										
									);

									//var_dump(time());

									if(!$this->_db->insert('Unit_Route_Data', $fields)) 
									{
										throw new Exception('There was a problem updating! ');
									}

									$this->Pack($seq, "Ack","Command_Ack",null, $rxsocket, $remote_ip , $remote_port);
								}else
								{
									$this->Pack($seq, "Nack","Value_Out_Bounds",null, $rxsocket, $remote_ip , $remote_port);
								}

								break;
							case '0x54':
								$this->e("Alarm Event received");

								$datarx = $this->getdata($hex,8);							//get data extracted from the received packet into an array

								if($datarx)
								{
									$value2 = hexdec($datarx[0]);
									$value3 = 0;

									if($value2 == 1 || $value2 == 6 || $value2 == 7)
									{
										$value3 = 0;
									}
									elseif($value2 == 3 || $value2 == 4 || $value2 == 5 || $value2 == 8 )
									{

										$value3 = hexdec($datarx[1]) << 8 | hexdec($datarx[2]);

									}
									else
									{
										$value3 = hexdec($datarx[1]);
									}

									$fields = array(
										
										'Unit_Id' => $RTU_ID,
										'Alarm_Type' => $value2,
										'Alarm_Value' => $value3,									
										'Timestamp' => date('Y-m-d H:i:s',time())
										
										
									);

									var_dump($datarx);

									if(!$this->_db->insert('Alarm_Event', $fields)) 
									{
										throw new Exception('There was a problem updating! ');
									}

									$this->Pack($seq, "Ack","Command_Ack",null, $rxsocket, $remote_ip , $remote_port);
								}else
								{
									$this->Pack($seq, "Nack","Value_Out_Bounds",null, $rxsocket, $remote_ip , $remote_port);
								}

								break;
							case '0x55':
								$this->e("Fault Event received");

								$datarx = $this->getdata($hex,8);							//get data extracted from the received packet into an array

								if($datarx)
								{
									$value2 = hexdec($datarx[0]);
									$value3 = 0;

									if($value2 == 2)
									{
										$value3 = 0;
									}
									else
									{
										$value3 = hexdec($datarx[1]);
									}

									$fields = array(
										
										'Unit_Id' => $RTU_ID,
										'Fault_Type' => $value2,
										'Fault_Value' => $value3,									
										'Timestamp' => date('Y-m-d H:i:s',time())
										
										
									);

									var_dump($datarx);

									if(!$this->_db->insert('Fault_Event', $fields)) 
									{
										throw new Exception('There was a problem updating! ');
									}

									$this->Pack($seq, "Ack","Command_Ack",null, $rxsocket, $remote_ip , $remote_port);
								}else
								{
									$this->Pack($seq, "Nack","Value_Out_Bounds",null, $rxsocket, $remote_ip , $remote_port);
								}

								break;
							case '0x56':
								$this->e("Ignition Event received");

								$datarx = $this->getdata($hex,8);							//get data extracted from the received packet into an array
								$currentLat = 0;
								$currentLong = 0;
								if($datarx)
								{
									$value2 = hexdec($datarx[0]);
									
									 if($dataDB = $this->_db->get('Unit_Route_Data', array('Unit_Id','=',$RTU_ID)))				//find the current position of RTU for trip start/stop position
									 {
									 	if($dataDB->counts() > 0)
									 	{
									 		$currentLat = $dataDB->last()->Lat;
									 		$currentLong = $dataDB->last()->Lon;
									 	}
									 }

									

									var_dump($datarx);

									if($value2 == 0)									//engin stop
									{
										$fields1 = array(
										
										'Trip_End_Time' =>  date('Y-m-d H:i:s',time()),				///do work to determine trips
										'End_Location_Lat' => $currentLat,	
										'End_Location_Long' => $currentLong
										
										
										);

										if($lasttrip = $this->_db->get('Unit_Trips',array('Unit_Id','=',$RTU_ID)))
										{
											if($lasttrip->counts() > 0)
											{
												$currentID = $lasttrip->last()->Id;								//find the most recent trip entered
											}
										


											if(!$this->_db->update('Unit_Trips',$currentID, $fields1)) 
											{
												throw new Exception('There was a problem updating! ');
												$this->Pack($seq, "Nack","Value_Out_Bounds",null, $rxsocket, $remote_ip , $remote_port);
											}	
											$this->Pack($seq, "Ack","Command_Ack",null, $rxsocket, $remote_ip , $remote_port);
										}													
									}
									else
									{													//engine start
										$fields2 = array(
										
										'Unit_Id' => $RTU_ID,
										'Trip_Start_Time' =>  date('Y-m-d H:i:s',time()),				///do work to determine trips
										'Start_Location_Lat' => $currentLat,									
										'Start_Location_Long' => $currentLong
																			
										);	

										if(!$this->_db->insert('Unit_Trips', $fields2)) 
										{
											throw new Exception('There was a problem Inserting! ');
											$this->Pack($seq, "Nack","Value_Out_Bounds",null, $rxsocket, $remote_ip , $remote_port);
										}
										$this->Pack($seq, "Ack","Command_Ack",null, $rxsocket, $remote_ip , $remote_port);
									}


									
								}else
								{
									$this->Pack($seq, "Nack","Value_Out_Bounds",null, $rxsocket, $remote_ip , $remote_port);
								}

								break;
							case '0x57':
								$this->e("Driver Event received");

								$datarx = $this->getdata($hex,8);							//get data extracted from the received packet into an array

								if($datarx){
									
									
									$driver_code = hexdec($datarx[0]) << 32 | hexdec($datarx[1]) << 16 | hexdec($datarx[2]) << 8 | hexdec($datarx[3]);

									var_dump($datarx);

									

									//////////////////////reserved for future use when driver cards are used



									$this->Pack($seq, "Ack","Command_Ack",null, $rxsocket, $remote_ip , $remote_port);
								}else
								{
									$this->Pack($seq, "Nack","Value_Out_Bounds",null, $rxsocket, $remote_ip , $remote_port);
								}

								break;
							default:
								$this->e("Wrong command byte");
								$this->Pack($seq, "NAck","Unknown_Command",null, $rxsocket, $remote_ip , $remote_port);
								break;
						}
					}else
					{
						$this->e("Unit not authorised");
						$this->Pack($seq, "NAck","Auth_Error",null, $rxsocket, $remote_ip , $remote_port);
					}

				}else
				{ 
					$this->e("Wrong start byte");
					$this->Pack($seq, "NAck","Wrong_Start_Byte",null, $rxsocket, $remote_ip , $remote_port);

				}
			}else
			{
				$this->e("CRC error");
				$this->Pack($seq, "NAck","CRC_Error",null, $rxsocket, $remote_ip , $remote_port);	

			}

			return $data;
		}



		public function Pack($seq2, $command,$data1,$data2, $rxsocket, $remote_ip , $remote_port)
		{
			$start_byte = 0x7E;
			$code = 0xFF;
			
											//Determine the command code and value code    command code is the command sent, the value code is the identifier for the data type i.e. CRC_Error
			switch ($command) {
				case 'Ack':
					$code = 0x00;
					if($data1 == "Command_Ack")
						$value = 0x01;
					elseif($data1 == "Key_Req")
						$value = 0x02;
					elseif($data1 == "Auth_Ack")
						$value = 0x03;

				break;


				case 'NAck':
					$code = 0x01;
					if($data1 == "Unknown_Command")
						$value = 0x01;
					elseif($data1 == "CRC_Error")
						$value = 0x02;
					elseif($data1 == "Auth_Error")
						$value = 0x03;
					elseif($data1 == "Unknown_ID")
						$value = 0x04;
					elseif($data1 == "Incorrect_Auth_Key")
						$value = 0x05;
					elseif($data1 == "IP_Not_Accepted")
						$value = 0x06;
					elseif($data1 == "Unknown_Error")
						$value = 0x07;
					elseif($data1 == "Error_Detail")
						$value = 0x08;
					elseif($data1 == "Wrong_Start_Byte")
						$value = 0x09;
					elseif($data1 == "Wrong_Value_Code")
						$value = 0x0A;
					elseif($data1 == "Value_Out_Bounds")
						$value = 0x0B;

				break;

				case 'Ping':
					$code = 0x02;
					$value = null;
				break;

				case 'Status_Req':
					$code = 0x21;
					if($data1 == "Unit_Status")
						$value = 0x01;
					elseif($data1 == "Location_Status")
						$value = 0x02;
					elseif($data1 == "FW_Status")
						$value = 0x03;
					elseif($data1 == "Alarm_Status")
						$value = 0x04;

				break;

				case 'New_Geo_Fence':
					$code = 0x22;
					if($data1 == "Circle")
						$value = 0x01;
					elseif($data1 == "Polygon")
						$value = 0x02;
					
				break;

				case 'New_Alarms':
					$code = 0x23;
					if($data1 == "Geo_Fence")
						$value = 0x01;
					elseif($data1 == "Speeding")
						$value = 0x02;
					elseif($data1 == "Stationary_Time")
						$value = 0x03;
					elseif($data1 == "Excessive_Distance_Travel")
						$value = 0x04;
					elseif($data1 == "Fuel_Usage")
						$value = 0x05;
					elseif($data1 == "Crash")
						$value = 0x06;
					elseif($data1 == "Soft_Lock")
						$value = 0x07;
					elseif($data1 == "Driver_Rest")
						$value = 0x08;


				break;

				case 'New_Config':
					$code = 0x24;
					if($data1 == "Position_Update_Rate_Sec")
						$value = 0x01;
					elseif($data1 == "Position_Update_Rate_Meters")
						$value = 0x02;
					elseif($data1 == "Position_Update_Rate_Stationary")
						$value = 0x03;
					elseif($data1 == "Buzzer")
						$value = 0x04;
					elseif($data1 == "Driver_Code")
						$value = 0x05;

				break;

				case 'Odometer_Reading':
					$code = 0x25;
					$value = null;

				break;

				case 'Soft_Lock':
					$code = 0x26;
					$value = null;

				break;

				case 'New_Host_IP':
					$code = 0x38;
					$value = null;

				break;
				case 'New_Host_Port':
					$code = 0x39;
					$value = null;

				break;
				case 'New_RTU_Port':
					$code = 0x40;
					$value = null;

				break;
				case 'SW_Update_Req':
					$code = 0x41;
					$value = null;

				break;
				
				default:
					# code...
					break;
			}



			$TXdata = [$start_byte,0x00,0x00,$seq2,0x00,0x00,0x00,$code];
			$length = 5;

			if($value)
			{
				
				array_push($TXdata, $value);								//add $value to data if applicable
				$length++;
			}

			if($data2)
			{
				for($i = 0; $i < sizeof($data2) ; $i++)						//add data to the data packet
				{
					array_push($TXdata, $data2[$i]);	
					$length++;
				}
			}


			$TXdata[1] = $length >> 8;										//calculate upper byte of length
			$TXdata[2] = $length & 0xFF; 									//calculate lower byte of length

			

			$crc = $this->crc_calc($this->hexToStr($TXdata));				//calculate crc for thw whole packet

			array_push($TXdata, $crc >> 8);									//add upper byte of crc to packet
			array_push($TXdata, $crc & 0xFF);								//add lower byte of crc to packet
			
			socket_sendto($rxsocket, $this->hexToStr($TXdata) , sizeof($TXdata) , 0 , $remote_ip , $remote_port); 
		}

		//
		//convert a string of hex values e.g. ("7e010020") into hex array [0x7E,0x00......]
		//
		private function strToHex($string){	
		    $hex = [];
		    
			for ($i=0; $i<strlen($string); $i+=2){
				$hexCode = "0x"  .strToUpper($string[$i]) .strToUpper($string[$i+1]);
				array_push($hex, $hexCode);
			}

		    
		   // var_dump($hex);
		    return $hex;
		}

		private function getdata($packet,$start){

			$data = [];

			for($i = $start ; $i < sizeof($packet) - 1 ; $i++ ){

				array_push($data , $packet[$i]);

			}

			return $data;

		}




		private function hexToStr($hex){
		    $string='';
		   // var_dump($hex);
		    for ($i=0; $i < sizeof($hex) ; $i++){
		      $string .= chr($hex[$i]);
		    }
		   // $this->e($string);
		    return $string;
		}

		private function e($str) {
		    GLOBAL $debug;
		    if( $debug) { echo($str . "\n"); }
		}

		private function strIntToHexCompare($string,$array){

			$hex = [];
			$int = (int)$string;
			
			$newArray = 0;
			for($i = 0; $i < sizeof($array) - 1; $i++){

				$newArray = ($newArray << 8) | hexdec($array[$i]); 
			}

			
			if($newArray == $int)
				return true;
			else
				return false;


		}

		private function getLength($upper,$lower){


			$length = hexdec($upper) << 8 | hexdec($lower);  //convert to int and shift upper bits left

			//var_dump($length);

			return $length;

		}

		private function getRTUID($ID1,$ID2,$ID3){

			$ID = hexdec($ID1) << 16 | hexdec($ID2) << 8 | hexdec($ID3);  ///convert to int and shift upper bits left

			//var_dump($ID);

			return $ID;

		}	

		private function crc_calc($data){
			//var_dump($data);
		   $crc = 0x1021;
		   for ($i = 0; $i < strlen($data); $i++)
		   {
		     $x = (($crc >> 8) ^ ord($data[$i])) & 0xFF;
		     $x ^= $x >> 4;
		     $crc = (($crc << 8) ^ ($x << 12) ^ ($x << 5) ^ $x) & 0xFFFF;
		   }
		  // var_dump($crc);
		   return $crc;
 
		}

		private function hexTo32Float($strHex) {
		    $v = hexdec($strHex);
		    $x = ($v & ((1 << 23) - 1)) + (1 << 23) * ($v >> 31 | 1);
		    $exp = ($v >> 23 & 0xFF) - 127;
		    return $x * pow(2, $exp - 23);
		}

	}







?>