
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
		require_once 'headinfo.php';// this adds css, javascript, bootstrap
		$id = $_GET['id'];

	?>   

	<script type="text/javascript">
		var userid = "";
		 function setID(userID) {
		    userid = userID;
		   
		}

		$(document).ready(function() {
         	var today = new Date();
		    var dd = today.getDate();
		    var mm = today.getMonth()+1; //January is 0!

		    var yyyy = today.getFullYear();
		    if(dd<10){
		        dd='0'+dd
		    } 
		    if(mm<10){
		        mm='0'+mm
		    } 
		    var today = yyyy +'-'+ mm + '-' + dd;											
		    //console.log(today);
         	//$('#deliverydate').val(today);
    		//$('#operationdate').val(today);
		    $(".date-picker").datepicker({dateFormat: 'yy-mm-dd'} );

			$(".date-picker").on("change", function () {
			    var id = $(this).attr("id");
			    var val = $("label[for='" + id + "']").text();
			    $("#msg").text(val + " changed");
			});

			
			myApp.hidePleaseWait();

		 			});
		</script>


</head> 
		
<body>
	<?php require_once 'slideMenu.php'; ?> 
	<!-- <pre>
		<?php //rint_r($_POST); ?>
	</pre>
	<pre>
		<?php //print_r($user); ?>
	</pre> -->

	<?php 
		 
		if($dbh = $_db->get('Event_Req', array("Id","=",$id))){    
				if($dbh->counts() > 0){
					foreach($dbh->results() as $key){
					
						$savedhospitalid = $key->Hospital;
						$saveddoctorid = $key->Doctor;
						//$saveddeliverydate = $key->Delivery_Date;
						$savedoperationdateandtime = $key->Operation_Date;
						$savedequipmentid = $key->Equipment_Required;
						$saveddeliverytypevalue = $key->Consignment;
						$savedrepattend = $key->Rep_Attend;
						$savednotes = $key->Comments;
					}
				}
		}
		//$saveddeliverydate = mb_substr($saveddeliverydate, 0, 10);
		$savedoperationdate = mb_substr($savedoperationdateandtime, 0, 10);
		$savedoperationtime = mb_substr($savedoperationdateandtime, 11, 15);
		

		//get hospital name from hospital ID
	    if($dbh = $_db->get('Hospitals', array('Id','=',$savedhospitalid))){
			if($dbh->counts() > 0){
				foreach ($dbh->results() as $key) {
					$savedhospitalname = $key->Name;
				}
			}
		}

		//get doctor name from doctor ID
	    if($dbh = $_db->get('Doctors', array('Id','=',$saveddoctorid))){
			if($dbh->counts() > 0){
				foreach ($dbh->results() as $key) {
					$saveddoctorname = $key->Name;
				}
			}
		}
		

		//get equipment description from equipment ID
	    if($dbh = $_db->get('Equipment_Sets', array('Id','=',$savedequipmentid))){
			if($dbh->counts() > 0){
				foreach ($dbh->results() as $key) {
					$savedequipmentdescr = $key->Description;
				}
			}
		}

		//get consignment or delivery text from saveddeliverytypevalue
		if ($saveddeliverytypevalue == 1) {
			$saveddeliverytype = "Consignment";
		} else
			$saveddeliverytype = "Delivery";

	?>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-lg-8 col-lg-offset-2">
				<div id="dataSaved" class="alert alert-success" role="alert">Event was successfully updated</div>
				<div id="dataNOTSaved" class="alert alert-danger" role="alert">Event could not be updated</div>
				<div id="eventdeleted" class="alert alert-success" role="alert">Event was successfully deleted</div>
				<div id="eventNotdeleted" class="alert alert-danger" role="alert">Event could not be deleted</div>

				<h3 class="col-xs-12"><span style="color:#00A7E1">Edit event</span></h3>
              	<p>Please complete event details below and click Update.</p>
				<table class="table table-hover" id="mytable">
				<thead>
					<!-- <tr><td>Field</td><td>Input</td></tr> -->
				</thead>
				<tbody >
								
					
					<tr ><td >Organiser</td><td id="organiser" ><?php echo $user->data()->Full_Name ?></td></tr>
					<tr class="hidden" ><td >Username</td><td id="username" ><?php echo $user->data()->Username ?></td></tr>

					<?php
						// //this section of code creates the doctor dropdown HTML
						// $doctordropdown = "";
						// $doctordropdown .="<select class=\"selectpicker\" id=\"doctor\">";
						// if($dbh = $_db->get('Doctors', array())){    
						// 	if($dbh->counts() > 0){
						// 		foreach($dbh->results() as $key){
						// 			$doctordropdown .= "<option>{$key->Name}</option>";
						// 		}
						// 	}
						// }
						// $doctordropdown .="</select>";
					?>



					<?php
						// //this section of code creates the hospital dropdown HTML
						// $hospitaldropdown = "";
						// $hospitaldropdown .="<select class=\"selectpicker\" id=\"hospital\">";
						// if($dbh = $_db->get('Hospitals', array())){    //get data from company table. No where statement required
						// 	if($dbh->counts() > 0){
						// 		foreach($dbh->results() as $key){
						// 			$hospitaldropdown .= "<option>{$key->Name}</option>";
						// 		}
						// 	}
						// }
						// $hospitaldropdown .="</select>";
					?>

					

					<?php
						//this section of code creates the equipment dropdown
						$equipmenttodeliver = "";
						$equipmenttodeliver .="<select class=\"myInputs selectpicker\" id=\"equipmenttodeliver\" >";
						if($dbh = $_db->get('Equipment_Sets', array())){    
							if($dbh->counts() > 0){
								foreach($dbh->results() as $key){
									$equipmenttodeliver .= "<option>{$key->Description}</option>";
								}
							}
						}
						$equipmenttodeliver .="</select>";
					?>

					<tr><td>Hosipital</td><td id="hospital"></td></tr>
					<tr><td>Doctor</td><td id="doctor"></td></tr>
					<!-- <tr><td>Delivery Date</td><td ><input id="deliverydate" class="myInputs date-picker" readonly></td></tr> -->
					<tr><td>Operation Date</td><td><input id="operationdate" class="myInputs date-picker" readonly></td></tr>
					<tr><td>OperationTime</td><td ><input id="operationtime" class="myInputs input-small" readonly></td></tr>
					<tr><td>Equipment required</td><td ><?php echo $equipmenttodeliver; ?></td></tr>
					<tr><td>Delivery type</td><td ><select class="myInputs" id="deliverytype"><option> Delivery </option><option> Consignment </option></select></td></tr>
					<tr><td>Rep attendance</td><td ><select class="myInputs" id="repattendance"><option> Yes </option><option> No </option></select></td></tr>
					<tr><td>Additional Notes</td><td ><textarea class="myInputs" name="additionalnotes" cols="14" rows="5" id="additionalnotes"></textarea></td></tr>
					<!-- <tr><td>Hosipital</td><td ><?php //echo $hospitaldropdown; ?></td></tr>
					<tr><td>Doctor</td><td ><?php //echo $doctordropdown; ?></td></tr>
					<tr><td>Delivery Date</td><td ><input id="deliverydate" class=" date-picker form-control" size="15" value="<?php //echo $saveddeliverydate; ?>"></td></tr>
					<tr><td>Operation Date</td><td><input id="operationdate" class="  date-picker form-control" size="15" value="<?php //echo $savedoperationdate; ?>"></td></tr>
					<tr><td>Operation Time</td><td ><input id="operationtime" size="5" class="input-small" value="<?php //echo $savedoperationtime; ?>"></td></tr>
					<tr><td>Required Equipment</td><td ><?php //echo $equipmenttodeliver; ?></td></tr>
					<tr><td>Delivery type</td><td ><select class="selectpicker" id="deliverytype"><option> Delivery </option><option> Consignment </option></select></td></tr>
					<tr><td>Rep attendance</td><td ><select class="selectpicker" id="repattendance"><option> Yes </option><option> No </option></select></td></tr>
					<tr><td>Additional Notes</td><td ><textarea name="additionalnotes" cols="14" rows="5" id="additionalnotes"></textarea></td></tr> -->
				</tbody>
			</table>
			</div>

			<!--hospital list modal-->
		<div class="modal fade" id="hospitallist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4>Please choose hospital from list</h4>
		            </div>
		            <div class="modal-body">
		               <table class="table hover" id="hospitalTable">
							<thead>
								<tr>
									<th>ID</th>
									<th>Hospital</th>
									
								</tr>
							</thead>
							<tbody id="hospitalTableBody">
							</tbody> 
						</table>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		                <!-- <a class="btn btn-success btn-ok" data-dismiss="modal" onclick="saveUsageUpdate()">Add Usages</a> -->
		            </div>
		        </div>
		    </div>
		</div><!--  end equipment list modal -->

		<!--doctor list modal-->
		<div class="modal fade" id="doctorlist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4>Please choose doctor from list</h4>
		            </div>
		            <div class="modal-body">
		               <table class="table hover" id="doctorTable">
							<thead>
								<tr>
									<th>ID</th>
									<th>Doctor</th>
									
								</tr>
							</thead>
							<tbody id="doctorTableBody">
							</tbody> 
						</table>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		                <!-- <a class="btn btn-success btn-ok" data-dismiss="modal" onclick="saveUsageUpdate()">Add Usages</a> -->
		            </div>
		        </div>
		    </div>
		</div><!--  end equipment list modal -->

			
			<script type="text/javascript">
				//This code writes None in additional commets field.
						var additionalnotes = document.getElementById('additionalnotes');
						additionalnotes.value = "None";
						additionalnotes.onfocus = function() {
							if (additionalnotes.value == "None") {
								additionalnotes.value = "";

							};					
						}
						additionalnotes.onblur = function() {
							if (additionalnotes.value == "") {
								additionalnotes.value = "None";

							};				
						}
						//This code populate inputs with saved inputs
						
						//set hospital name
						var hospital = document.getElementById('hospital');
						var savedhospitalname = "<?php echo $savedhospitalname ?>";
						hospital.innerHTML = savedhospitalname+'<a href="#" data-toggle="modal" data-target="#hospitallist">    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
						//set doctor name
						var doctor = document.getElementById('doctor');
						var saveddoctorname = "<?php echo $saveddoctorname ?>";
						doctor.innerHTML = saveddoctorname+'<a href="#" data-toggle="modal" data-target="#doctorlist">    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';

						//set equipment description
						var equipmenttodeliver = document.getElementById('equipmenttodeliver');
						var savedequipmenttodeliver = "<?php echo $savedequipmentdescr ?>";
						equipmenttodeliver.value = savedequipmenttodeliver;

						//set rep attendance
						var repattendance = document.getElementById('repattendance');
						var savedrepattend = "<?php echo $savedrepattend ?>";
						repattendance.value = savedrepattend;

						//set Additional Notes
						var additionalnotes = document.getElementById('additionalnotes');
						var savednotes = "<?php echo $savednotes ?>";
						additionalnotes.value = savednotes;

						//set delivery type
						var deliverytype= document.getElementById('deliverytype');
						var saveddeliverytype = "<?php echo $saveddeliverytype ?>";
						deliverytype.value = saveddeliverytype;
						

						/*set delivery date
						// var deliverydate= document.getElementById('deliverydate');
						// var saveddeliverydate = "<?php echo $saveddeliverydate ?>";
						// deliverydate.value	= saveddeliverydate;
						*/
						//set operation date
						var operationdate= document.getElementById('operationdate');
						var savedoperationdate = "<?php echo $savedoperationdate ?>";
						operationdate.value	= savedoperationdate;

						//set operation time
						var operationtime= document.getElementById('operationtime');
						var savedoperationtime = "<?php echo $savedoperationtime ?>";
						operationtime.value	= savedoperationtime;


						var id = "<?php echo $id ?>";
			</script>


		</div>
		<div>
		<!-- <h4>Step 2 : Please click SAVE to save the event.</h4> -->
		<!--<input type="hidden" name="saved" value="1" />-->
	
		<button class="btn btn-success col-lg-offset-2" data-toggle="modal" data-target="#confirm-save">
	   		Update
		</button>

		<button class="btn btn-warning" data-toggle="modal" data-target="#confirm-delete">
	   		Delete
		</button>

		
	
		<!--confirm update modal-->
		<div class="modal fade" id="confirm-save" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4>Confirm event details</h4>
		            </div>
		            <div class="modal-body">
		               Are you sure you want to update this event?
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		                <a class="btn btn-success btn-ok" onclick="updateEvent()" data-dismiss="modal">Update</a>
		            </div>
		        </div>
		    </div>
		</div><!--  end confirm modal -->

		
	
		<!--confirm delete modal-->
		<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4>Confirm event details</h4>
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


		<!--</form>-->
		</div>
		<!--  <div><a href="home.php"><br/>Return to Home Page</a></div> -->
		<br/><br/><br/>
						
	</div>


	<script type="text/javascript">
		$('#dataNOTSaved').hide();
		$('#dataSaved').hide();
		$('#eventdeleted').hide();
		$('#eventNotdeleted').hide();
	
		 $('#operationtime').timepicker({
            minuteStep: 15,
            template: 'dropdown',
            appendWidgetTo: 'body',
            showSeconds: false,
            showMeridian: false,
            //defaultTime: 'current'
        });

		 var myApp;
			myApp = myApp || (function () {
			    var pleaseWaitDiv = $('<div class="modal " id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false"><div class="modal-body " \
			    	    style="color:#FFF"><div class=" vertical-center"><h1 style="width:100%" class="text-center">Loading data...</h1>  </div>  </div></div>');
			    return {
			        showPleaseWait: function() {
			            pleaseWaitDiv.modal('show');
			        },
			        hidePleaseWait: function () {
			            pleaseWaitDiv.modal('hide');
			        },

			    };
			})();
		
		 myApp.showPleaseWait();

		 function setHospitaltable(){	        
				var table = new $('#hospitalTable').DataTable();
		
				
				// table1.column(3).visible(false); //hide doctor name col
				// table1.column(5).visible(false); //hide required equipmet col
	     
				
				$('#hospitalTable tbody').on( 'click', 'tr', function () {	        	          
				    selectedRow = $(this);	 
				    hospital = selectedRow[0].children[1].innerHTML; 
				    document.getElementById("hospital").innerHTML=hospital+'<a data-toggle="modal" data-target="#hospitallist">    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
					//following code enables create button 
				
					if ((hospital.length > 0) && (doctor.length > 0)) {
							$('#createbutton').removeAttr('disabled');
					};

					$('#hospitallist').modal('hide');	
			
				});
			}

		function setDoctortable(){	        
				var table = new $('#doctorTable').DataTable();
		
				
				// table1.column(3).visible(false); //hide doctor name col
				// table1.column(5).visible(false); //hide required equipmet col
	     
				
				$('#doctorTable tbody').on( 'click', 'tr', function () {	        	          
				    selectedRow = $(this);	 
				    doctorname = selectedRow[0].children[1].innerHTML; 
				    document.getElementById("doctor").innerHTML=doctorname+'<a data-toggle="modal" data-target="#doctorlist">    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
					
					//following code enables create button 
					if ((hospital.length > 0) && (doctor.length > 0)) {
							$('#createbutton').removeAttr('disabled');
					};
				
					$('#doctorlist').modal('hide');	
			
				});
			}


		function populateHospitalTable(RTU_data,RTU_data1){

			 var newSpare = document.getElementById('hospitalTableBody');
			      var newHtml;
		       	  newHtml = '<tr><td>' + RTU_data  +'</td><td>' + RTU_data1  +'</td></tr>';
		          newSpare.innerHTML += newHtml;	          
			}

		function populateDoctorTable(RTU_data,RTU_data1){

			 var newSpare = document.getElementById('doctorTableBody');
			      var newHtml;
		       	  newHtml = '<tr><td>' + RTU_data  +'</td><td>' + RTU_data1  +'</td></tr>';
		          newSpare.innerHTML += newHtml;	          
			}


		function deleteEvent(){
			
			
			$.ajax({   								//ajax call to insert data into DB on save
			      type: "POST",
			      url: "../Functions/deleteEvent.php",
			      data: {Id:id},
			      success: function(data) {
			        
			        
			        if(data == 1)   //if save is successfull
			        {
			        	$('#eventdeleted').show();
						$('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page

			        	// $('#eventdeleted').show();
			        	// $('#eventNotdeleted').hide();
			        	
			        	
			        	//var mytime = setInterval(function(){ $('#eventdeleted').hide();  clearInterval(mytime);}, 1800);
			        	//redirect to home page after 2 sec
			        	window.setTimeout(function(){
			        		window.location.href = "./home.php";
			        	}, 2500);
			        	

			        }else
			        {
			        	$('#eventNotdeleted').show();
			        	$('#eventdeleted').hide();
			        	
			        	
			       		var mytime = setInterval(function(){ $('#eventNotdeleted').hide();  clearInterval(mytime); }, 4000);
			        } 
			      }
			    });
			
		

		}


		function updateEvent(){
			var table = document.getElementById('mytable');
	    	//1-this section gets organiser details from table   
	        for (var r = 0, n = table.rows.length; r < n; r++) {
	            for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
	                //alert(table.rows[r].cells[c].innerHTML);
	            }
	        }
	        
	       

	        var organiser = table.rows[0].cells[1].innerHTML;
	        var username = table.rows[1].cells[1].innerHTML;
	    	//1-end 

	    	var hospitalcell = document.getElementById('hospital').innerHTML;
	    	var hospital = hospitalcell.substr(0, hospitalcell.indexOf('<'));			
			var doctorcell = document.getElementById('doctor').innerHTML;
			var doctor = doctorcell.substr(0, doctorcell.indexOf('<'));
			
			// var deliverydate = document.getElementById('deliverydate').value;
			var operationdate = document.getElementById('operationdate').value;
	    	var operationtime = document.getElementById('operationtime').value;
	    	var equipmenttodeliver = document.getElementById('equipmenttodeliver').value;
	  		var repattendance = document.getElementById('repattendance').value;
	  		var additionalnotes = document.getElementById('additionalnotes').value;
	  		var deliverytypetext= document.getElementById('deliverytype').value;


	      	//alert(deliverytypetext);
	    	//alert(organiser + hospital + doctor + deliverydate + operationdate);
			// alert(hospital);
			// alert(doctor);
			// alert(deliverydate);
			// alert(operationdate);
			// alert(operationtime);
			// alert(equipmenttodeliver);
			// alert(additionalnotes);
			
			

			if(organiser.length > 0)   
			{
			 $.ajax({   								//ajax call to insert data into DB on save
			      type: "POST",
			      url: "../Functions/saveEditEvent.php",
			      data: {Id:id, Organiser:username, Hospital:hospital, Doctor:doctor, Operationdate:operationdate, Operationtime:operationtime, Equipmenttodeliver:equipmenttodeliver, 
			      		Deliverytypetext:deliverytypetext, Repattendance:repattendance, Additionalnotes:additionalnotes},
			      success: function(data) {
			        
			        $('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
			        if(data == 1)   //if save is successfull
			        {
			        	// $('#dataSaved').show();
			        	// $('#dataNOTSaved').hide();
			        	$('#dataSaved').show();
				        $('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
			        	
			        	//var mytime = setInterval(function(){ $('#dataSaved').hide();  clearInterval(mytime);}, 1800);
			        	

			        	
					    	 
					    	 
					    	 var message = "Update - Org:" + organiser + ", Hosp:" + hospital  + ", Equip:" + equipmenttodeliver + ", Date:" + operationdate + " " + operationtime;
				        	//console.log(message.length);
				        	
				        	$.ajax({   								//ajax call to insert data into DB on save
						      type: "POST",
						      url: "../Functions/sendMessageAjax.php",
						      data: {Type:"Event_Update",Data:message,Originator:userid},
						      success: function(data) {
						    	 
						    	 
						    	// console.log(data);
						    	// console.log(organiser);
						      }
						    });
					    	// console.log(organiser);
					     



					    	//redirect to home page after 2 sec
			        	window.setTimeout(function(){
			        		window.location.href = "home.php";
			        	}, 1000);
			        	

			        }else
			        {
			        	$('#dataNOTSaved').show();
			        	$('#dataSaved').hide();
			        	
			        	
			       		var mytime = setInterval(function(){ $('#dataNOTSaved').hide();  clearInterval(mytime); }, 4000);
			        } 
			      }
			    });
			}else
			{
				$('#dataNOTSavedLimit').show();
				$('#dataSaved').hide();
				

				var mytime = setInterval(function(){ $('#dataNOTSavedLimit').hide(); clearInterval(mytime); }, 4000);
			}
			
	    }


		</script>

		<?php
			$myId = $user->data()->Id;
			echo "<script type='text/javascript'> setID($myId); </script>";


			if($dbh = $_db->get('Hospitals', array())){    //get data from event table. No where statement required
				if($dbh->counts() > 0){
					foreach($dbh->results() as $key){
						echo "<script  type=\"text/javascript\"> populateHospitalTable($key->Id, \"$key->Name\"); </script>";


					}
				}
			}

			if($dbh = $_db->get('Doctors', array())){    //get data from event table. No where statement required
				if($dbh->counts() > 0){
					foreach($dbh->results() as $key){
						echo "<script type=\"text/javascript\"> populateDoctorTable($key->Id, \"$key->Name\"); </script>";


					}
				}
			}
			echo "<script type='text/javascript'> setHospitaltable(); </script>";
			echo "<script type='text/javascript'> setDoctortable(); </script>";


		?>


	
</body>	
	
</html>
