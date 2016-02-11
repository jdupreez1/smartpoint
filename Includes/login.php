

<?php
	
	require_once '../Core/init.php';
	
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Orchestrate</title>
	<?php
	
	 require_once 'headinfo.php'; ?>

	<script type="text/javascript">
	
	
		

	
	function notVerifiedShow(){    //function to show the alert showing user is not verified
		$('#notVerified').show();
	}
	
	</script>

</head>
<body>

<div class="container">
	
	<div class="row">
		<div id = "notVerified" class="alert alert-danger col-xs-12" role="alert">Sorry, you must first verify your email address. Click <a href="../Scripts_Internal/sendVerifyEmail.php?Username=<?php echo input::get('Username')?>" class="alert-link">here</a> to resend the verification email</div>
	
	</div> <!--Row div-->

<?php
$token = false;
$input = false;
if(input::exists()){ 
	$input = true;
		if(token::check(input::get('token'))) {

			$token = true;
		}else
		{
			$token = false;
		}
}
?>




	<div class="row">
		<div class="col-xs-12">
			<p><br/><br/>Welcome to the Orchestrate website. Please log in to continue. <br/></p>
			<form action="" method="post" class="form-inline" role="form">

				<div class="form-group">
					<label for="Username">Username</label>
					<input type="text" name="Username" class="form-control" id="Username" autocomplete="off">
				</div>

				<div class="form-group">
					<label for="Password">Password</label>
					<input type="password" name="Password" class="form-control" id="pwd" autocomplete="off">
				</div>

				<div class="checkbox">
					<label><input type="checkbox" name="remember"> Remember me</label>
				</div>
				
				<button type="submit" class="btn btn-default" name="token" value="<?php echo token::generate();?>">Submit</button>
			</form>
		</div>
	</div> <!--Row div-->
	
</div>  <!--container div -->
<script type="text/javascript">
	
	$('#notVerified').hide();
</script>

</body>
</html>
<?php		
if($input == true){
if($token == true){	
			$validate = new validate();
			$validation = $validate->check($_POST,array(
				'Username' => array('required' => true)
				 
			));
			
			if($validation->passed()) {
				$user = new user(null,$_log);
				
				$remember = (input::get('remember') === 'on') ? true : false;
				
					$login = $user->login(input::get('Username'),input::get('Password'), $remember);
					
					if($user->verified(input::get('Username')) && $user->find(input::get('Username')))
					{
						if($login) {
							redirect::to('../index.php');
						
						}
							
					}else
					{
						echo "<script type='text/javascript'> notVerifiedShow(); </script>";
					}

					// else {
					// 	echo 'Sorry, logging in failed';
					// }
				
			}
			else {
				foreach($validation->errors() as $error) {
					echo $error, '<br>';
				}	
			}			
		}
		else {
			$_log->warning('Wrong form token received on login attempt'); // Will be logged 

			//echo "Sorry, token does not match";
		}
}

		

?>