<?php
ob_start();
	require_once('./Core/init2.php');

	
	if(session::exists('home')) {
		echo '<p>' . session::flash('home') . '</p>';
	} 
	
	
	$user = new user(null,$_log);
	
	if($user->isLoggedIn()) {
	
		
		redirect::to('./Includes/home.php');
		
		
				
	
	}
	else {
		redirect::to('./Includes/login.php');
	}
?>