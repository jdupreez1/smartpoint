<?php
	require_once '../Core/init.php';
	$user = new user(null,$_log);
	$_db = db::getInstance();
	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}
	if(!$user->hasPermission("Driver") && !$user->hasPermission("Rep"))
	{
		redirect::to('../Includes/home.php');
	}
?>

<html>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Orchestrate</title>
	<?php 
		require_once 'headinfo.php' ; // this adds css, javascript, bootstrap
	?> 
	<script src="js/deliveryUpdate.js"></script> <!-- include related javascript file -->
 </head> 
		
<body>
	<?php 
		require_once 'slideMenu.php';  	
	?>
	<div class="container">

	<?php if(!isset($_GET['id'])){  ?>
		<div class="row">
			<div class="col-xs-12 col-lg-10">
				<div id="dataSaved" class="alert alert-success" role="alert">Event was successfully saved</div>
				<div id="dataNOTSaved" class="alert alert-danger" role="alert">Event was not saved</div>
				<h3 class="col-xs-12"><span style="color:#00A7E1">Delivery Update</span></h3>
              	<p>Please select event to update.</p>
				<div class="table-responsive">
					<table class="table" id="event_table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Organiser</th>
							    <th>Hospital</th>
							    <th>Doctor</th>
								<th>Operation Date</th>
								<th>Required Equip</th>   
							</tr>
						</thead>
						<tbody id="eventTableBody">
						</tbody> 
					</table>
					<div class='row' id='nodata'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>  Sorry, no applicable events found to update</div>
				</div>
			</div>
		</div>
		<script type='text/javascript'> getEvents('acked'); </script>

	<?php }else{ ?>  

		<?php 
			$eventid = $_GET["id"];
		?>

		<script type="text/javascript">
			var eventid = <?php echo $eventid ?>;
		</script>
		
		<div class="row">
			<div class="col-xs-12 col-lg-10">
				<div id="dataSaved" class="alert alert-success" role="alert">Delivery update sucessfully added</div>
				<div id="dataNOTSaved" class="alert alert-danger" role="alert">Failed to add delivery update</div>
				<h3 class="col-xs-12"><span style="color:#00A7E1">Delivery Update</span></h3>
              	<p>Please complete delivery details below and click Add Update.</p>
				
           		<table class="table " id="eventupdate_table">
					<thead>
						<tr>
							<th>Field</th>
						    <th>Input</th>						    
						</tr>
					</thead>
					<tbody id="eventUpdateTableBody">
						<tr><td>Delivered by </td><td id="deliveredby"></td></tr>
						<tr><td>Equipment delivered </td><td id="equipmentdescription"></td></tr>
						<tr><td>Set Serial No</td><td ><input class="myInputs" id="setserial"></td></tr>
						<tr><td>CSSD Name </td><td><input class="myInputs" type="text" id="cssdname"></td></tr>
						<tr><td>Date </td><td><input class="myInputs date-picker" type="text" id="delivereddate" readonly></td></tr>
						<tr><td>Time </td><td><input class="myInputs" type="text" id="deliveredtime" readonly></td></tr>
						<tr><td>Event Comments </td><td id="eventcomments"></td></tr>						
						<span type="hidden" value="<?php echo $_GET['id']?>">
					</tbody> 
				</table>
				
				<button id="addUpdateButton" class="btn btn-success" data-toggle="modal" data-target="#confirm-update">
		   			Add Update
				</button>
			
				<!--confirm delivery modal-->
				<div class="modal fade" id="confirm-update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				    <div class="modal-dialog">
				        <div class="modal-content">

				            <div class="modal-header">
				                <h4>Confirm delivery details</h4>
				            </div>
				            <div class="modal-body">				             
								<input type="checkbox" id="confirmcheckbox" style="width: 20px"> By clicking this checkbox I confirm that I am delivering the following equipment sets:<br/><br/> <span id="equipmentlist"> </span> <br/><br/><br/>
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				                <a id="submitButton" class="btn btn-success btn-ok" onclick="saveDeliveryUpdate()" data-dismiss="modal">Add details</a>
				            </div>				     
				        </div>
				    </div>
				</div><!--  end confirm modal -->

			</div>

		</div>

		<?php } ?>
				
	</div>
</body>	
</html>
