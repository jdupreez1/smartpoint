
<?php
	require_once '../Core/init.php';

	$user = new user(null,$_log);
	$_db = db::getInstance();
	$isrep = false;
	$isdriver = false;
	$ismanager = false;
	$isfinance = false;

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

	if($user->hasPermission("Manager"))
	{
		$ismanager = true;	
	}
	if($user->hasPermission("Finance"))
	{
		$isfinance = true;	
	}	
?>

<html>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Orchestrate</title>

	
	<?php require_once 'headinfo.php';// this adds css, javascript, bootstrap
		require_once 'slideMenu.php';
			
	?>
	<script src="js/home.js"></script> <!-- include home page javascript file -->
	<!-- <script src="../Scripts_Internal/home.js"></script> -->
</head> 
		
<body id="body">	
	<div class="container"> 
		<div class="row">
			<div class="col-xs-12">
			<div id = "Alert" class="hidden alert alert-danger" role="alert"></div>
				<div id='calendar'></div>
			</div>
		</div>
	</div>

	<!-- 1st Modal [Event Actrions] -->
	<div class="modal fade" id="eventClickModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Choose update type</h4>
	      </div>
	      <div class="modal-body">
	        <table id="modalTable" class="table  table-hover table-bordered">
	        	<thead></thead>
	        	<tbody class="text-center ">
	        		<tr id="deliveryupdatebuttn"><td>Delivery Update</td></tr>
	        		<tr id='usagesupdatebuttn'><td>Usages Update</td></tr>
	        		<tr id='patientupdatebuttn'><td>Patient Details Update</td></tr>
		        	<tr id="collectionupdatebuttn"><td>Collection Update</td></tr>
		        	<tr id="refillupdatebuttn"><td>Refill Update</td></tr>
		        	<tr id="invoiceupdatebuttn"><td>Invoice Update</td></tr>
		        	<tr id="eventupdatebuttn" class="info"><td>Event Details</td></tr>
	        	</tbody>
	        </table>
	        <span><div><strong>Driver: </strong></div><div id="driverName"></div></span>
	        <button id="ackBtn" class ="btn btn-success hidden col-xs-12 " onclick="ackEvent(1)" style="margin-bottom:3">Acknowledge</button>
	         <button id="unAckBtn" class ="btn btn-warning hidden col-xs-12 " onclick="ackEvent(0)" style="margin-bottom:3">Unacknowledge Event</button>
	         <button id="editBtn" class ="btn btn-info hidden col-xs-12 " onclick="editEvent()" style="margin-bottom:3">Edit Event</button>
	           <button id="deleteBtn" class="btn btn-warning col-xs-12" data-toggle="modal" data-target="#confirm-delete">
		   		Delete
			</button>
	         
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top:5;">Close</button>
	        
	      </div>
	    </div>
	  </div>
	</div>


	<!-- 2nd Modal [Event Details] -->	
	<div class="modal fade" id="eventDetailsClickModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h3 class="modal-title" id="myModalLabel" style="color:#00A7E1">Event Information</h3>

	      </div>
	      <div id="allEventDetails" class="modal-body">
	       <div id="eventDetails">
	        <table class="table  table-hover table-bordered">
	        	<thead><h4 style="color:#00A7E1"> Event Requirements </h4></thead>
	        	<tbody >	        		
	        		<tr><td>Organiser: </td><td  id="OrganiserRow"> </td></tr>
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
	      	<button type="button" class="btn btn-default" onclick="PrintContent()">Print</button>
	      	<?php
	      		if($isrep || $isdriver){
			      	echo '<button type="button" class="btn btn-default" onclick="closeModal2()">Back</button> ';
			      }
			    ?>
	        <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
	        
	      </div>
	    </div>
	  </div>
	</div>


  <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <div class="modal-header">
			                <h4>Confirm event deletion</h4>
			            </div>
			            <div class="modal-body">
			               Are you sure you want to delete this event?
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			                <a class="btn btn-success btn-ok" onclick="deleteEvent()" data-dismiss="modal">Delete</a>
			            </div>
			        </div>
			    </div>
			</div><!--  end confirm modal -->

	
	<?php
		$myid = $user->data()->Id;
		$myname = $user->data()->Full_Name;

		echo "<script type='text/javascript'> setID($myid,'$myname'); </script>";
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


		if($ismanager)
		{
			echo "<script type='text/javascript'> setManager(1); </script>";
		}else
		{
			echo "<script type='text/javascript'> setManager(0); </script>";
		}

		if($isfinance)
		{
			echo "<script type='text/javascript'> setFinance(1); </script>";
		}else
		{
			echo "<script type='text/javascript'> setFinance(0); </script>";
		}

	?>

	<link rel="stylesheet" type="text/css" href="../Styles/calendar.css"/>   <!--does not seem to work -->
	
		
</body>	

</html>
