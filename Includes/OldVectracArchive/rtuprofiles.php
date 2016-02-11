<?php
	require_once '../Core/init.php';
	$dbh = null;
	
	$user = new user(null,$_log);
	$_db = db::getInstance();
	
	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Vectrack</title>


		
	</head>
	<?php require_once 'add_headinfo.php'; ?>



	<?php $myid = $user->data()->Company_Id; // Get username of user so that only users RTU's can be dispalyed?> 
	<body>
		<!-- <pre>
			//<?php print_r($_POST) ?>
		</pre> -->

		<?php require_once 'add_navbar.php'; ?>

		
		<?php 
		$save =  $mycheck = !isset($_POST['didsave']) ? 0 : $_POST['didsave'];
			if ($save == 1) { 

				
				if (isset($_POST["Geo_Fence"])) 	
					$array["Geo_Fence"] = "1";
				else 
					$array["Geo_Fence"] = "0";

				if (isset($_POST["Crash"])) 	
					$array["Crash"] = "1";
				else 
					$array["Crash"] = "0";

				if (isset($_POST["Soft_Lock"])) 	
					$array["Soft_Lock"] = "1";
				else 
					$array["Soft_Lock"] = "0";
			

				$dbh = $_db->updateUnit('Unit_Alarm_Setup', $_POST["rtuid"], array(
				'Geo_Fence' => $array["Geo_Fence"], 
				'Crash' => $array["Crash"],
				'Soft_Lock' => $array["Soft_Lock"],
				'Speeding' => !isset($_POST['speeding']) ? 0 : $_POST['speeding'], 
				'Stationary_Time' => !isset($_POST['stationaryTime']) ? 0 : $_POST['stationaryTime'], 
				'Excess_Distance' => !isset($_POST['excessDistance']) ? 0 : $_POST['excessDistance'], 
				'Excess_Fuel' => !isset($_POST['excessFuel']) ? 0 : $_POST['excessFuel'], 
				'Driver_Rest' => !isset($_POST['driverRest']) ? 0 : $_POST['driverRest'] ));

				$dbh2 = $_db->updateUnit('Units', $_POST["rtuid"], array(			
				'Secondary_Email_Notification' => !isset($_POST['rtu_sec_email']) ? "" : $_POST['rtu_sec_email'], 
				'Unit_Description' => $_POST["rtu_descr"] ));

				if ($dbh && $dbh2) {
					echo "<div class=\"container alert alert-success\" role=\"alert\">SUCCESSFULLY UPDATED DB</div>";
					# code...
				}
			}
		
		?>

		<?php 
		$editrtu =  $mycheck = !isset($_POST['editrtu']) ? 0 : $_POST['editrtu'];
			if ($editrtu == 1) : ?>
			<div class="container">

				<?php echo "<br/>" ?>
				<?php echo "<br/>" ?>
						
				<div class="row">

					<div class='col-lg-6'>
						<h4> Step 1 : Please edit description and notification details below. </h4><br/>	
						<table  class="table table-hover"> 
							<tr><th>Field</th><th>Data</th></tr>
							<form action="" method="post" role="form">
								<?php 

									if($dbh = $_db->get('Units', array('Unit_Id','=',$_POST["rtuid"]))){
										if($dbh->counts() > 0){
											foreach ($dbh->results() as $key) {
												echo "<tr><td>RTU ID</td><td>{$_POST["rtuid"]}</td></tr>";
												echo "<tr><td>RTU Description</td><td><input type=\"text\" name=\"rtu_descr\" value=\"$key->Unit_Description\"></td></tr>";
												echo "<tr><td>Secondary Email Notification</td><td><input type=\"text\" name=\"rtu_sec_email\" value=\"$key->Secondary_Email_Notification\"></td></tr>";
											}
										}
									}
								?>
						</table>
					</div>

					<div class='col-lg-6'>
						<h4> Step 2 : Please do alarm configuration below. </h4><br/>	
						<table class="table table-hover"> 
							<tr><th>Alarm Type</th><th>Enable/Value</th></tr>
							
								<?php 



									if($dbh = $_db->get('Unit_Alarm_Setup', array('Unit_Id','=',$_POST["rtuid"]))){
										if($dbh->counts() > 0){
											foreach ($dbh->results() as $key) {
												
												echo "<tr><td>Geo Fence</td>";
												if ($key->Geo_Fence == 1) {
													
													echo "<td><input type=\"checkbox\" name=\"Geo_Fence\" value=\"1\" checked><br></td>";
													} else {
													echo "<td><input type=\"checkbox\" name=\"Geo_Fence\" value=\"0\"><br></td>";
												}
												echo "<tr><td>Crash</td>";
												if ($key->Crash == 1) {
													
													echo "<td><input type=\"checkbox\" name=\"Crash\" value=\"1\" checked><br></td>";
													} else {
													echo "<td><input type=\"checkbox\" name=\"Crash\" value=\"0\"><br></td>";
												}
												echo "<tr><td>Soft Lock</td>";
												if ($key->Soft_Lock == 1) {
													
													echo "<td><input type=\"checkbox\" name=\"Soft Lock\" value=\"1\" checked><br></td>";
													} else {
													echo "<td><input type=\"checkbox\" name=\"Soft Lock\" value=\"0\"><br></td>";
												}


												echo "<tr><td>Speeding Alarm</td><td><input size=\"6\" type=\"text\" name=\"speeding\" value=\"$key->Speeding\"> km/h</td></tr>";
												echo "<tr><td>Stationary Time</td><td><input size=\"6\" type=\"text\" name=\"stationaryTime\" value=\"$key->Stationary_Time\"> mins</td></tr>";
												echo "<tr><td>Excess Distance</td><td><input size=\"6\" type=\"text\" name=\"excessDistance\" value=\"$key->Excess_Distance\"> km</td></tr>";
												echo "<tr><td>Excess Fuel</td><td><input size=\"6\" type=\"text\" name=\"excessFuel\" value=\"$key->Excess_Fuel\"> liters</td></tr>";
												echo "<tr><td>Driver Rest</td><td><input size=\"6\" type=\"text\" name=\"driverRest\" value=\"$key->Driver_Rest\"> min</td></tr>";
												
												
											}
										}
									}
									
								?>
								<input type="hidden" name="myid" value="<?php echo $myid ?>">
								<input type="hidden" name="rtuid" value="<?php echo $_POST["rtuid"] ?>">
								<input type="hidden" name="editrtu" value="1">
								<input type="hidden" name="didsave" value="1">
							
						</table>
					</div>

					<div class="container row col-lg-6">
							<h4>Step 3 : Click save button to save your changes.</h4>
							<input type="submit" value="Save" />
							</form>
							<div><a href="rtuprofiles.php"><br/>Return to RTU Profiles Page</a><br/><br/><br/><br/></div>
					</div>
					

				</div>
			</div>
		<?php  else : ?>
		
			<div class="container">
				
				<div class="row">
					
					<div class="col-lg-6">
						<h4><br/><br/>The table below displays all your configured RTU's. By clicking on the corresponding edit button, you have the option to edit the description, email notification address and alarm settings of each RTU. <br/><br/></h4>
						<table id="rtu_table" class="table table-hover"> 
							<thead>
							<th>RTU ID</th><th>RTU Description</th><th>Email Notification Address</th><th>Action</th>
							</thead>
							<tbody >
							<?php
								 
								if($dbh = $_db->get('Units', array('Company_Id','=',$myid))){
									if($dbh->counts() > 0){
										foreach ($dbh->results() as $key) {
											
											echo "<tr><td> $key->Unit_Id </td><td> $key->Unit_Description </td><td> $key->Secondary_Email_Notification </td><td>" ;   //test post line
											echo "<form action=\"\" method=\"post\" role=\"form\">";
											echo "<div class=\"form-group\">";
											echo "<input type=\"hidden\" name=\"rtuid\" value=\"{$key->Unit_Id}\">";
											echo "<input type=\"hidden\" name=\"editrtu\" value=\"1\">";
											echo "<input type=\"submit\" value=\"Edit\" />";
											echo "</form>" ;
											echo "</td></tr>";

										}
										echo "<script type='text/javascript'> var table = new $('#rtu_table').DataTable(); </script>";
									}

								}
								else {
									echo "Could not read from DB";
								}
							?>
							</tbody>
						</table>
						<div><a href="home.php"><br/>Return to Home Page</a><br/><br/><br/><br/></div>
					</div>
				</div>
			<?php endif;
				

			  ?>



			</div>


	</body>

	
</html>


