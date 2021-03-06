<?php
	session_start();
	
	$GLOBALS['config'] = array(
	
	//mysql config
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => 'Linode@11334455',
		'db' => 'Booking'	
		), 
	
	//cookie config for remebering users
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
		
		),
	//session config	
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
		)	
		
	);

	//auto include classes
	spl_autoload_register(function($class){
		
		require_once '../Classes/' . $class . '.php';
				
	});

	//include functions
	
	require_once '../Functions/sanitize.php';
	require_once '../vendor/autoload.php';
	
	//$logger = new Katzgrau\KLogger\Logger('../Log',Psr\Log\LogLevel::DEBUG);	

$_log = new Logger('../Log',Psr\Log\LogLevel::DEBUG);

	//check whether cookie is stored and user logged in
	if(cookie::exists(config::get('remember/cookie_name')) && !session::exists(config::get('session/session_name'))) {
		$hash = cookie::get(config::get('remember/cookie_name'));
		$hashCheck = db::getInstance();
		$hashCheck->get('User_Sessions', array('Hash','=',$hash));
		
		if($hashCheck->counts()) {
			
			$user = new user($hashCheck->first()->User_Id,$_log);
			$user->login();
		}
		
	}
	
?>