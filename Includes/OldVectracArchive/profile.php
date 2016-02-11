<?php
	require_once '../Core/init.php';
	
	if(!$username = input::get('user')) {
		redirect::to('../index.php');
			
	}
	else
	{
		$user = new user($username,$_log);
		if(!$user->exists()){
			redirect::to(404);
		}
		else {
			$data = $user->data();
			
		}
		?>
	
		<h3><?php echo escape($data->User_Name);?></h3>
		<p>Full name: <?php echo escape ($data->Name);?></p>
	<?php	
	}

?>