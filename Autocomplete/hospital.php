<?php

	require_once '../Core/init.php';

	$user = new user(null,$_log);
	$_db = db::getInstance();
	
	

	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}

	$query = $_GET['query'];
	

	$suggestions = array();
	//$users = array();
	$hospitals = array();

	$singleUser = array();
	
	

		if($dbh = $_db->get('Hospitals', array('Name','LIKE',$query.'%'))){    //get data from event table. No where statement required
				if($dbh->counts() > 0){
					
					foreach($dbh->results() as $key)
					{	

							$singleHospital = array(
							'value' =>  $key->Name
							
							);
							array_push($hospitals, $singleHospital);
						
					
					}
					$suggestions = array(
						'suggestions'=> $hospitals
						);

					//array_push($suggestions, $users);
					echo  json_encode($suggestions) ;
					
					

					
				}else
				{
					echo "Nothing found in DB";
				}

			}
			else {
				echo "Could not read from DB";
			}
		




?>