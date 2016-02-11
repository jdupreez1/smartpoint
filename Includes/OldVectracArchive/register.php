<?php
ob_start();
	require_once '../Core/init.php';
	
	$user = new user(null,$_log);
	
	if(!$user->isLoggedIn() || !$user->hasPermission('Admin')) {
		redirect::to('../index.php');
	}
	
	if(input::exists()){
		if(token::check(input::get('token'))){
		$validate = new validate();
		$validation = $validate->check($_POST, array(
			'Username' => array(    //Item must be same as db field
				'required' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'Users'  //name of table as value
			),
			
			'Password' => array(
				'required' => true,
				'min' => 6
			),
			'password_again' => array(
				'required' => true,
				'matches' => 'Password'
			),
			'Name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50,
			)
		
		));
		
		if($validation->passed()) {
			//session::flash('success','You registered successfully!');
			//header('Location: index.php');
			$user = new user(null,$_log);
			$salt = hash::salt(32);
			
			try{
				$user->create(array(
					'Username' => input::get('Username'),
					'User_Group' => 3,
					'Password' => hash::make(input::get('Password'),$salt),
					'Salt' => $salt
					
					
				));
				session::flash('home', 'You have been registered');
				redirect::to('index.php');
				
			}catch(Exception $e){
				//echo $e->getMessage(), '<br>';
				die($e->getMessage());
			}
		}
		else{
			foreach($validation->errors() as $error){
				echo $error, '<br>';
			}
		}
		}

	}
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Vectrack</title>
	</head>
	<?php require_once 'add_headinfo.php'; ?>
	<body>
		<?php require_once 'add_navbar.php'; ?>
		<div class="container">
			<div class="col-xs-12">
				<p><br/><br/>To register a new user, please complete boxes below and click sumbit. <br/></p>
				<form action="" method="post" class="form-inline" role="form">

					<div class="form-group">
						<label for="Username">Username</label>
						<input type="text" name="Username" id="Username" value="<?php echo escape(input::get("Username"))?>" class="form-control" autocomplete="off">
					</div>

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
























<!-- <form action ="" method= "post">
		<div class="field">
			<label for="Username">Username</label>
			<input type="text" name="Username" id="Username" value="<?php echo escape(input::get("Username"))?>" autocomplete="off">
		</div>

		<div class="field">
			<label for="Password">Enter password</label>
			<input type="password" name="Password" id="Password">
		</div>

		<div class="field">
			<label for="password_again">Enter password again</label>
			<input type="password" name="password_again" id="password_again">
		</div>
		
		<div class="field">
			<label for="Name">Enter name</label>
			<input type="text" name="Name" id="Name" value="<?php echo escape(input::get("name"))?>" autocomplete="off">
		</div>
		<input type="hidden" name="token" value="<?php echo token::generate();?>">
		<input type="submit" value="Register">
</form> -->

