<?php 

	require_once '../Core/init.php';
	$dbh = null;
	
	$user = new user(null,$_log);
	$_db = db::getInstance();
	

	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}



	//echo "You are about to add a RTU to User with User Id = " . $_POST["User_Id"];

	print_r($_POST);

?>
