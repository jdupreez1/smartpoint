<?php
	require_once '../Core/init.php';
	
	$user = new user(null,$_log);
	

	if($user->verified($_GET['Username']) ) {      
		redirect::to('../index.php');
	}	
	
	$_db = db::getInstance();

	$username = $_GET["Username"];
	$confirmCode = $_GET["ConfirmCode"];
	
	//echo $unit_id;
	

	if(input::exists()){
		if(token::check(input::get('token'))){
		$validate = new validate();
		$validation = $validate->check($_POST, array(
						
			'Password' => array(
				'required' => true,
				'min' => 6
			),
			'password_again' => array(
				'required' => true,
				'matches' => 'Password'
			)
			
		
		));
		
		if($validation->passed()) {
			//session::flash('success','You registered successfully!');
			//header('Location: index.php');
			$user = new user(null,$_log);
			$salt = hash::salt(32);
			



			if($data = $_db->get('Users',array('Username','=',$username)))
			{
				

				//var_dump($data);

				if($data->counts() > 0)
				{
					if($data->first()->User_Verified == 0)
					{

						if($data->first()->Confirm_Hash == $confirmCode)
						{
							$oldUser = $data->first()->Old_User;

							try{
								$user->updateUser(array(
									
									'Password' => hash::make(input::get('Password'),$salt),
									'Salt' => $salt,		
									'User_Verified' => 1,
									'Confirm_Hash' => null,
									'Old_User' => null
						
									
								),$_GET['Username']);
								session::flash('home', 'Your password has been created');
								$_log->info('Username verified: ' . $username); // Will be logged 

								if($oldUser  !== null){
									try{
										if($user->delete($oldUser))
											$_log->info('Old user deleted: ' . (string)$oldUser );
										else
											$_log->warning('Old user NOT deleted: ' . (string)$oldUser );

									}catch(Exception $e){
										var_dump($e->getMessage());
										$_log->info($e->getMessage() );
										die($e->getMessage());
									}

								}
								


								if($user->login($username,input::get('Password')))   //log user in
								{

									redirect::to('../index.php');
								}      
								
							}catch(Exception $e){
								$_log->info('Could not update verify user in DB', $fields); // Will be logged 
								//throw new Exception('There was a problem updating! ');
								redirect::to('../Includes/Errors/verificationFailed.php?Message=Database error');
								die($e->getMessage());
							}



						}else
						{
							$_log->warning("User verification failed with wrong confirm code for user : " . $username);
							//echo "User verification failed";
							redirect::to('../Includes/Errors/verificationFailed.php?Message=User confirmation code wrong');
						}

					}else
					{
						$_log->info("User already verified for username: " . $username);
						//echo "User already verified'";
						redirect::to('../index.php');
					}

				}
			}else
			{
				$_log->info('Could not read user from Users table to verify email');
				//echo "Could not read from database";
				redirect::to('../Includes/Errors/verificationFailed.php?Message=User not found in database');	
			}


					
		}
		else{
			foreach($validation->errors() as $error){
				echo $error, '<br>';
			}
		}
		}else
		{
			echo "Wrong token received";
		}

	}else
	{
		//echo "no input";
	}




	

?>




<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Vectrack</title>
	</head>
		<?php require_once '../Includes/headinfo.php'; ?>
	<body>
		
		<div class="container">
			<div class="col-xs-12">
				<p><br/><br/>Please select your password: <br/></p>
				<form action="" method="post" class="form-inline" role="form">

					

					<div class="form-group">
						<label for="Password">Enter password</label>
						<input type="password" name="Password" id="Password" class="form-control" autocomplete="off">
					</div>

					<div class="form-group">
						<label for="password_again">Enter password again</label>
						<input type="password" name="password_again" class="form-control" id="password_again" autocomplete="off">
					</div>

					<button type="submit" class="btn btn-default" name="token" value="<?php echo token::generate();?>">Submit</button>
				</form>
			</div>
		</div>
	</body>
</html>








<?php
ob_start();
	require_once '../Core/init.php';
	
	
	$_db = db::getInstance();



	
	
?>

