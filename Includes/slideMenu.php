
<?php

	$user = new user(null,$_log);
	
	$isrep = false;
	$isdriver = false;
	$ismanager = false;
	$isadmin = false;
	$isfinance = false;
	
	
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

	if($user->hasPermission("Admin"))
	{
		$isadmin = true;
	}
	if($user->hasPermission("Finance"))
	{
		$isfinance = true;
	}

?>


<nav class="navbar navbar-default navbar-inverse" role="navigation">
	<div class="container-fluid">
	<div class="navbar-brand"><a href="../Includes/home.php">Orchestrate</a></div>

		<!-- <div class="navbar-brand"><a href="home.php">Booking</a></div> -->
		<a href="#my-menu">
			<button type="button" class="navbar-toggle" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</a>
		

				
				
			
		<!-- I don't want it apart of the collapsible portion -->
		<div class="collapse navbar-collapse ">
			<ul id = "nav_list" class="nav navbar-nav">

				<li><a href="#my-menu"><strong>Menu</strong></a></li>
				
			</ul>
		</div>
	</div>
</nav>

<nav id="my-menu">
	<ul>
		<li><a href="../Includes/home.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>  Home</a></li>
		<li class="nav-divider"></li>
		<?php 
			if($isrep){
				echo '<li><a href="../Includes/createEvent.php"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span>  Create Event</a></li>';
			}
		?>
		<?php 
		if($isrep || $isdriver){
		 echo '<li>';
			
			 echo '<span href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>  Update Event</span>';
			 echo '<ul>';
				//<!-- <li><a href="eventUpdate.php">Event Update</a></li> -->
				 echo '<li><a href="../Includes/deliveryUpdate.php"><span class="glyphicon glyphicon-road" aria-hidden="true"></span>  Delivery Update</a></li>';
				 echo '<li><a href="../Includes/usagesUpdate.php"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>  Usages Update</a></li>';
				 echo '<li><a href="../Includes/patientUpdate.php"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>  Patient Details Update</a></li>';
				
					//if($isrep){
						// echo '<li><a href="../Includes/patientUpdate.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>  Patient Details Update</a></li>';
					//	echo '<li><a href="../Includes/usagesUpdate.php"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>  Usages Update</a></li>';
					//}
				
				 echo '<li><a href="../Includes/collectionUpdate.php"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>  Collection Update</a></li>';
				 echo '<li><a href="../Includes/refillUpdate.php"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>  Refill Update</a></li>';
				
			 echo '</ul>';
			
		 echo '</li>';
		} ?>
		<?php 
			if($isfinance ){
				 echo '<li>';
			
			 	echo '<span href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>  Update Event</span>';
			 		echo '<ul>';
				//<!-- <li><a href="eventUpdate.php">Event Update</a></li> -->
				 
				 echo '<li><a href="../Includes/patientUpdate.php"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>  Patient Details Update</a></li>';
				echo '<li><a href="../Includes/invoiceUpdate.php"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>  Invoice Update</a></li>';
					//if($isrep){
						// echo '<li><a href="../Includes/patientUpdate.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>  Patient Details Update</a></li>';
					//	echo '<li><a href="../Includes/usagesUpdate.php"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>  Usages Update</a></li>';
					//}
				
				 
				
			 echo '</ul>';
			
		 echo '</li>';
			}
		?>
		
		<?php 
			if(!$ismanager && !$isfinance  ){
				echo '<li><a href="../Includes/calender.php"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>  Calender</a></li>';
			}
		?>
		<li class="nav-divider"></li>		
		<li><a href="../Includes/instantMessage.php"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>  Instant Message</a></li>
		<li class="nav-divider"></li>
		
		
		<?php 
			if($ismanager){
				
						// <li><a href="eventUpdate.php">Event Update</a></li> -->
						echo '<li><a href="../Includes/reports.php"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span>  Reports</a></li>';
						
			}
		?>
		<?php 
			if($ismanager || $isadmin){
				echo '<li>';
					echo '<span href="#"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>  Admin</span>';
					echo '<ul>';
						// <li><a href="eventUpdate.php">Event Update</a></li> -->
						echo '<li><a href="../Includes/users.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>  Users</a></li>';
						echo '<li><a href="../Includes/notifications.php"><span class="glyphicon glyphicon-bell" aria-hidden="true"></span>  Notifications</a></li>';
						
						//echo '<li><a href="collectionUpdate.php">Collection Update</a></li>';
						
					echo '</ul>';
				echo '</li>';
			}
		?>
		
		<li><a href="../Includes/logout.php"><span class="glyphicon glyphicon-hand-down" aria-hidden="true"></span>  Logout</a></li>	
		<li class="nav-divider"></li>	
		<li><a id="help" href="#"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>  Help</a></li>
		<?php 
			if($isrep){
				echo '<li><a href="../Includes/contactDeveloper.php"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>  Contact Developer</a></li> ';
			}
		?>
		
		<li class="nav-divider"></li>
		<li><a href="../Includes/userGroup.php">Change user group - Temp</a></li>
		<!--<li><a href="../Test_Scripts/testSendMessage.php">test send - Temp</a></li>-->
		
	</ul>
</nav>

<!-- Modal -->
	<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Calendar Help</h4>
	      </div>
	      <div class="modal-body">
	        <table id="modalTable" class="table  table-hover table-bordered">
	        	<thead >
	        		<th>Colour</th>
	        		<th>Meaning</th>
	        	</thead>
	        	<tbody >
	        		
		        	<tr><td><input class="redlegend col-xs-12"/></td><td>Event not acknowledged by driver</td></tr>		        	
		        	<tr><td><input class="orangelegend col-xs-12"/></td><td>Event acknowledged by me</td></tr>
		        	<tr><td><input class="bluelegend col-xs-12"/></td><td>My event acknowledged by driver</td></tr>
		        	<tr><td><input class="greenlegend col-xs-12"/></td><td>My event - set delivered</td></tr>
		        	<tr><td><input class="maroonlegend col-xs-12"/></td><td>Set ready to be collected</td></tr>
		        	<tr><td><input class="pinklegend col-xs-12"/></td><td>Set ready to be refilled</td></tr>
		        	<tr><td><input class="greylegend col-xs-12"/></td><td>Set collection completed - Event closed</td></tr>
	        	</tbody>
	        </table>
	        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        
	      </div>
	    </div>
	  </div>
	</div>

	<!-- <div><a href="#my-menu"><button type="button" class="btn btn-primary"> <span class="glyphicon glyphicon-star" aria-hidden="true"></span></button></a></div> -->



<script type="text/javascript">



	$(document).ready(function(){
		$("#my-menu").mmenu({
			header:true
         });
     

		
		// Following section of code rests menu to home when selection is made in sub menu

		 $('.mm-title').click(function() {
		      // Finds the current active mmenu.
		      var mmenu = $('.mmenu-nav.mm-current');
		      if (mmenu.hasClass('mm-horizontal')) {
		        // For horizontal mmenu when slidingSubmenus option is set to Yes.
		        $('> .mm-panel', mmenu).addClass('mm-hidden').removeClass('mm-opened mm-subopened mm-highest mm-current');
		        $('#mm-0').removeClass('mm-hidden mm-subopened').addClass('mm-opened mm-current');
		      }
		      else {
		        // For vertical mmenu when slidingSubmenus option is set to No.
		        $('> .mm-panel .mm-opened', mmenu).removeClass('mm-opened');
		      }
		    });	
	});

	$('#help').click( function() { 

		$('#helpModal').modal('show');

	} );
</script>

