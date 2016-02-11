<?php
	require_once '../Core/init.php';

	Class controllerHelper {
			
			
			
			
		public static function checkChangeRequests(){
			$DB  = db::getInstance();
			
			//echo "Checking for any change requests <br>";	
			
			$DB->get('Request_Status_Change',array());
			
			$jsondata = array();
			$results = $DB->results();
			
			if($DB->counts()) {
			$x = 0;	
				foreach($results as $result) {
			
				//$jsonData['success'] = 1;
				//$jsonData['count'] = $DB->counts();	
				$jsondata[$x]['id'] = $result->Id;
				$jsondata[$x]['device_id'] = $result->Device_Id;
				$jsondata[$x]['requested_state'] = $result->Requested_State;	
				$x++;
			}
		
			return json_encode($jsondata,JSON_FORCE_OBJECT);
			
			}
			else{
				//$jsondata['success'] = 0;
				//$jsondata['message'] = "0 records found";	
				
				//return json_encode($jsondata);
				return false;
			}
			
			
		}	
			
		public static function updateDbWithRequest($id,$device_id,$requested_state) {
			$DB = db::getInstance();
						
			if(!$DB->update('Devices',$device_id,array(	"Device_Current_Status" => $requested_state 
				
					
			))) {
							
						//throw new Exception('There was a problem making request');
						return false;
				}
			else{
					$DB->Insert('Info_Exchange',array('Device_Status_Updated'=>1));
				
					echo "updating device with id {$device_id} to {$requested_state} ({$id}) <br>";
					if(!$DB->delete('Request_Status_Change',array("Id","=",	$id	))) {
							
						//throw new Exception('There was a problem making request');
						return false;	
					}
					else{
						//echo "deleting request with id " . $id . "<br>";
						return true;	
					//echo "yay";
					}	//echo "yay";
			}
					return false;
		
		}
		
		public static function checkRFData(){
			
			if(input::exists())
			{
				
				if(isset($_POST['rfdata']))
				{
					
					echo input::get('rfdata');
					
					
				}
				
				
				
			}
			
			
		}
		
	
	}

?>