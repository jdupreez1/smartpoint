<?php
 class ip{
 	
	public static function getip(){
 			
 		$ipaddress = $_SERVER["REMOTE_ADDR"];

		return $ipaddress;
 	}

	public static function gethost($ip){	
		$host = gethostbyaddr($ip);
		
		return $host;
	}		
	
	public static function checklocal(){
		
		gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
	}
 }
?>