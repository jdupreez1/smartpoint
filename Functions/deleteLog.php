<?php
require_once '../Core/init.php';
	
	
	$user = new user(null,$_log);
	
	
	if(!$user->isLoggedIn()) {
		redirect::to('index.php');
	}

	if(!$user->hasPermission("Admin"))
	{
		redirect::to('index.php');	
	}
 	


 	$files = scandir('../Log');
 	
 	$_log->info('Trying to delete log');
 	for($i = 2; $i < sizeof($files); $i++) {
	  	
	  	
 		if($i == sizeof($files) -1 )
 		{
 			if(file_put_contents("../Log/" . $files[$i], "") !== false)
 			{
	    		$_log->info('Log file deleted by user: ' . $user->data()->Username);
	    		echo "File deleted";

	    	}
	    	else
	    	{
	    		$_log->info('Log file NOT deleted by user: ' . $user->data()->Username);
	    		echo "File not deleted";
			}
 		}else
 		{
	 		if(unlink("../Log/" . $files[$i]))
	 		{
	    		
	    		echo "File deleted";

	    	}
	    	else
	    	{
	    		$_log->info('Log file NOT deleted by user: ' . $user->data()->Username);
	    		echo "File not deleted";
			}
		}
	}
	
	
	
?>