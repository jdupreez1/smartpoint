<?php
	
	require '../Core/init.php';
	
	$user = new user(null,$_log);
	
	$user->logout();
	redirect::to('../index.php');

