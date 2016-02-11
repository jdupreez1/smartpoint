<?php
	require_once '../Core/init.php';
	$dbh = null;
	
	$user = new user(null,$_log);
	$_db = db::getInstance();
	
	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');

	}
	
	if(input::exists()){
		if(token::check(input::get('token'))){
			$validate = new validate();
			$validation = $validate->check($_POST,array(
				'Name' => array(
					'required' => true,
					'min' => 2,
					'max' => 50
				)
			));
			
			if($validation->passed()) {
				
				try{
					$user->update(array(
						'Name' => input::get('Name')
					));
					session::flash('home','Your details have been updated. ');
					redirect::to('index.php');
					
				}
				catch(Exception $e) {
					die($e->getMessage());
					
				}
				
			}
			else {
				foreach($validation->errors() as $error) {
					echo $error, '<br>';
				}
			}
			
			
		}
	}



	// if (!isset($_POST["didsave"])) {
	// 	$_POST["didsave"] = 0;
	// }

	if ($_POST["didsave"] == 1) {
	
		$dbh = $_db->update('Users', $_POST["lineid"], array(
				'Username' => $_POST["Username"],
				'User_Cellphone' => $_POST["Cellno"]));

		

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
		
		<!-- <pre>
			<?php //echo print_r($_POST) ?>;
		</pre> -->
		<div class="container">
			<div class="row">
				<div class="col-lg-12">

					<?php if (isset($dbh)) { ?>
							<div class="alert alert-success" role="alert">SUCCESSFULLY UPDATED DB</div>
					<?php ; } ?>

					<h4> Step 1 : Please update your user profile below and click save. </h4><br/><br/>
					<table class="table table-hover"> 
						<tr><th>Field</th><th>Data</th></tr>
						<form action="" method="post" role="form">						
							<?php
								//echo $user->data()->Username;
								echo "<tr><td>Username</td><td><input type=\"text\" name=\"Username\" value=\"{$user->data()->Username}\"></td></tr>";
								echo "<tr><td>Cell Number</td><td><input type=\"text\" name=\"Cellno\" value=\"{$user->data()->User_Cellphone}\"></td></tr>";
							?>
					</table>
					
							<h4>Step 2 : Click save to save your configuration changes.</h4>
							<input type="hidden" name="didsave" value="1" />
							<input type="hidden" name="lineid" value="<?php echo $user->data()->Id; ?>"/>
							<input type="submit" value="Save" />
						</form>
					<div><a href="home.php"><br/>Return to Home Page</a></div>
				</div>
			</div>
		</div>


	</body>
</html>



