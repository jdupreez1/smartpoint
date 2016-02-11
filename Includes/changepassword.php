<?php
	require_once '../Core/init.php';
	
	$user = new user(null,$_log);
	
	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}
	
	if(input::exists()){
		if(token::check(input::get('token'))){
			
			$validate = new validate();
			$validation = $validate->check($_POST,array(
				'password_current' => array(
					'required' => true,
					'min' => 6
					
				),
				'password_new' => array(
					'required' => true,
					'min' => 6
					
				),
				'password_new_again' => array(
					'required' => true,
					'min' => 2,
					'matches' => 'password_new'
					
				)
			));
			
			if($validation->passed()) {
				
				if(hash::make(input::get('password_current'), $user->data()->Salt) !== $user->data()->Password) {
					echo 'The current password you entered is not correct. ';
				}
				else {
					$salt = hash::salt(32);
					$user->update(array(
						'Password' => hash::make(input::get('password_new'),$salt),
						'Salt' => $salt
					
					));
					
					session::flash('home','Your password has been changed successfully. ');
					redirect::to('index.php');
				}
			}
			else {
				foreach($validation->errors() as $error) {
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
				<p><br/><br/>To change your user password, please complete boxes below and click sumbit. <br/></p>
				<form action="" method="post" class="form-inline" role="form">

					<div class="form-group">
						<label for="password_current">Enter current password</label>
						<input type="password" name="password_current" class="form-control" id="password_current" autocomplete="off">
					</div>

					<div class="form-group">
						<label for="password_new">Enter new password</label>
						<input type="password" name="password_new" class="form-control" id="password_new" autocomplete="off">
					</div>

					<div class="form-group">
						<label for="password_new_again">Enter new password again</label>
						<input type="password" name="password_new_again" class="form-control" id="password_new_again" autocomplete="off">
					</div>

					<button type="submit" class="btn btn-default" name="token" value="<?php echo token::generate();?>">Submit</button>
				</form>
			</div>
		</div>
	</body>
</html>


