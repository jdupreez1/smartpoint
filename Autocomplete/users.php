<?php

	require_once '../Core/init.php';

	$user = new user(null,$_log);
	$_db = db::getInstance();
	
	

	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}

	$query = $_GET['query'];
	

	$suggestions = array();
	$users = array();
	$singleUser = array();
	
	

		if($dbh = $_db->get('Users', array('Full_Name','LIKE',$query.'%'))){    //get data from event table. No where statement required
				if($dbh->counts() > 0){
					
					foreach($dbh->results() as $key)
					{	

							$singleUser = array(
							'value' =>  $key->Full_Name,	
							'data' => $key->Username
							
							);
							array_push($users, $singleUser);
						
					
					}
					$suggestions = array(
						'suggestions'=> $users
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