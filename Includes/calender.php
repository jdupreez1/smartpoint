
<?php
	require_once '../Core/init.php';

	$user = new user(null,$_log);
	$_db = db::getInstance();
	$isrep = false;
	$isdriver = false;

	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}

	if($user->hasPermission("Rep"))
	{
		$isrep = true;	
	}

	if($user->hasPermission("Driver"))
	{
		$isdriver = true;	
	}	
?>


<html>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Orchestrate Booking System</title>
	  <?php 
		require_once 'headinfo.php';// this adds css, javascript, bootstrap
	?> 
	
	<script src="js/calender.js"></script> <!-- include calender page javascript file -->


</head> 
		
<body>
	<?php require_once 'slideMenu.php' ?> 
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div id='calendar'></div>
			</div>
		</div>
	</div>	

	<!-- Modal2 for event details -->
	
	<div class="modal fade" id="eventDetailsClickModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h3 class="modal-title" id="myModalLabel" style="color:#00A7E1">Event Information</h3>
	      </div>
	      <div class="modal-body">
	           <div id="eventDetails">
	        <table class="table  table-hover table-bordered">
	        	<thead><h4 style="color:#00A7E1"> Event Requirements </h4></thead>
	        	<tbody >	        		
	        		<tr><td>Organiser: </td><td  id="OrganiserRow"> </td></tr>
	        		<!-- <tr><td>Requested Delivery Date: </td><td id="DeliveryDateRow"> </td></tr> -->
	        		<tr><td>Operation Date:</td><td id="OperationDateRow"></td></tr>
		        	<tr><td>Hospital: </td><td id="HospitalRow"> </td></tr>
		        	<tr><td>Doctor: </td><td id="DoctorRow"> </td></tr>
		        	<tr><td>Equipment Required: </td><td id="EquipmentRow"> </td></tr>
		        	<tr><td>Rep Attendance: </td><td id="RepAttendRow"> </td></tr>
		        	<tr><td>Consignment Set: </td><td id="ConsignmentRow"> </td></tr>
		        	<tr><td>Comments: </td><td id="CommentRow"> </td></tr>
		        	<tr><td>Current Status: </td><td  id="StatusRow"> </td></tr>
		        	<tr><td>Event Logged: </td><td  id="EventLoggedRow"> </td></tr>
	        	</tbody>
	        </table>
	       </div>
	        <div id="deliveryDetails">
	          <table class="table  table-hover table-bordered">
	        	<thead><h4 style="color:#00A7E1"> Delivery Information </h4></thead>
	        	<tbody >
	        		<tr><td>Delivered by: </td><td id="DriverRow"></td></tr>
	        		<tr><td>Set Serial: </td><td id="SetserialRow"></td></tr>
	        		<tr><td>CSSD Name: </td><td id="CSSDNameRow"></td></tr>
	        		<tr><td>Delivery Time: </td><td id="DeliveryTimeRow"></td></tr>
	        		<tr><td>Delivery Logged: </td><td id="DeliveryLoggedRow"></td></tr>
	        	</tbody>
	        </table>
	        </div>	
 			<div id="usageDetails">
	          <table class="table  table-hover table-bordered">
	        	<thead><h4 style="color:#00A7E1"> Usage Information </h4></thead>
	        	<tbody >
	        		<tr><td>Patient Name: </td><td id="PatientNameRow"></td></tr>
	        		<tr><td>Patient No: </td><td id="PatientNoRow"></td></tr>
	        		<tr><td>Patient Order No: </td><td id="PatientOrderNoRow"></td></tr>
	        		<tr><td>Usages: </td><td id="UsagesRow"></td></tr>
	        		<tr><td>Usage Logged: </td><td id="UsageLoggedRow"></td></tr>
	        	</tbody>
	        </table>
	        </div>	
	        <div id="collectionDetails">
	          <table class="table  table-hover table-bordered">
	        	<thead><h4 style="color:#00A7E1"> Collection Information </h4></thead>
	        	<tbody >
	        		<tr><td>Collected By: </td><td id="CollectedByRow"></td></tr>
	        		<tr><td>Collection Time: </td><td id="CollectedTimeRow"></td></tr>
	        		<tr><td>Equipment Used: </td><td id="EquipmentUsedRow"></td></tr>
	        		<tr><td>Collection Logged: </td><td id="CollectionLoggedRow"></td></tr>
	        	</tbody>
	        </table>
	        </div>	
	         <div id="invoiceDetails">
	          <table class="table  table-hover table-bordered">
	        	<thead><h4 style="color:#00A7E1"> Invoice Information </h4></thead>
	        	<tbody >
	        		<tr><td>Invoiced By: </td><td id="InvoiceByRow"></td></tr>
	        		<tr><td>Invoice Number: </td><td id="InvoiceNumberRow"></td></tr>
	        		<tr><td>Invoice Amount: </td><td id="InvoiceAmountRow"></td></tr>
	        		<tr><td>Date Invoiced: </td><td id="DateInvoicedRow"></td></tr>
	        		<tr><td>Invoice Logged: </td><td id="InvoicedLoggedRow"></td></tr>
	        	</tbody>
	        </table>
	        </div>	
	      </div>
	      <div class="modal-footer">
	      	<!-- <button type="button" class="btn btn-default" onclick="closeModal2()">Back</button> -->
	        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="PrintContent()">Print</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<?php
		$myid = $user->data()->Id;

		echo "<script type='text/javascript'> setID($myid); </script>";
		if($isrep)
		{
			echo "<script type='text/javascript'> setRep(1); </script>";
		}else
		{
			echo "<script type='text/javascript'> setRep(0); </script>";
		}

		if($isdriver)
		{
			echo "<script type='text/javascript'> setDriver(1); </script>";
		}else
		{
			echo "<script type='text/javascript'> setDriver(0); </script>";
		}
	?>
		
	<link rel="stylesheet" type="text/css" href="../Styles/calendar.css"/>   <!--does not seem to work -->
	
</body>	

</html>
