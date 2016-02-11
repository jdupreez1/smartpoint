
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
		require_once 'headinfo.php'// this adds css, javascript, bootstrap
		//echo '<script type="text/javascript"> myApp.showPleaseWait();</script>';
	?>   

	<script type="text/javascript">
		

			
		
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

		    //set operation time picker 
		 	$('#operationtime').timepicker({
	            minuteStep: 15,
	            template: 'dropdown',
	            appendWidgetTo: 'body',
	            showSeconds: false,
	            showMeridian: false,
	            //defaultTime: 'current'
	        });


		 	//set date pickers time picker 
	     	//$('#deliverydate').val(today);
			$('#operationdate').val(today);



			var date = new Date();
			date.setDate(date.getDate());
			//alert(date);

			$('.date-picker').datepicker({    //using JQUERY UI datepicker not bootstrap
				dateFormat: 'yy-mm-dd',
			    minDate: date

			});


		 //    $(".date-picker").datepicker({
		 //    		dateFormat: 'yy-mm-dd',
		 //    		startDate : today,
		    		
			// } );
			$(".date-picker").on("change", function () {
			    var id = $(this).attr("id");
			    var val = $("label[for='" + id + "']").text();
			    $("#msg").text(val + " changed");
			});

			//This code sets default delivery date to current date 
			// deliverydate.onblur = function() {
			// 	if (deliverydate.value == "") {
			// 		deliverydate.value = today;

			// 	}			
			// };
			//END  of default delivery date

			//This code sets default operation date to current date 
			operationdate.onblur = function() {
				if (operationdate.value == "") {
					operationdate.value = today;

				}			
			};
			//END  of default time
			

			//This code sets default operation time to current time 
			now = operationtime.value;				
			operationtime.onblur = function() {
				if (operationtime.value == "") {
					operationtime.value = now;

				}			
			};
			//END  of default time

			//  This sets default default comment to "None"
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
			//END of default comment
			myApp.hidePleaseWait();
		});

	</script>


</head> 
		
<body>
	<?php require_once 'slideMenu.php' ?> 
	<!-- <pre>
		<?php //print_r($_POST); ?>
	</pre>
	<pre>
		<?php //print_r($user); ?>
	</pre> -->
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-lg-8 col-lg-offset-2">
				<div id="dataSaved" class="alert alert-success " role="alert">Event was successfully created</div>
				<div id="dataNOTSaved" class="alert alert-danger " role="alert">Event could not be created</div>
					<?php echo '<script type="text/javascript"> $("#dataNOTSaved").hide(); $("#dataSaved").hide(); </script>'?>
				<h3 class="col-xs-12"><span style="color:#00A7E1">Create event</span></h3>
              	<p>Please complete event details below and click Create.</p>
              	<div class="table-responsive">
					<table class="table table-hover" id="mytable">
					<thead>
						<!-- <tr><td>Field</td><td>Input</td></tr> -->
					</thead>
					<tbody id="mytablebody">
									
						
						<tr ><td >Organiser</td><td id="organiser" ><?php echo $user->data()->Full_Name ?></td></tr>
						<tr class="hidden" ><td >Username</td><td id="username" ><?php echo $user->data()->Username ?></td></tr>

						<?php
							//this section of code creates the doctor dropdown HTML
							// $doctordropdown = "";
							// $doctordropdown .="<select class=\"selectpicker myInputs\" id=\"doctor\">";
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
							// $hospitaldropdown .="<select class=\"selectpicker myInputs\" id=\"hospital\">";
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
							$equipmenttodeliver .="<select class=\"myInputs\" id=\"equipmenttodeliver\">";
							if($dbh = $_db->get('Equipment_Sets', array())){    
								if($dbh->counts() > 0){
									foreach($dbh->results() as $key){
										$equipmenttodeliver .= "<option>{$key->Description}</option>";
									}
								}
							}
							$equipmenttodeliver .="</select>";
						?>					


						<tr><td>Hospital</td><td id="hospitalname" ><a href="#" data-toggle="modal" data-target="#hospitallist">  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></td></tr>
						<tr><td>Doctor</td><td id="doctorname"><a href="#" data-toggle="modal" data-target="#doctorlist">  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></td></tr>
						<!-- <tr><td>Delivery Date</td><td ><input id="deliverydate" class="myInputs date-picker" readonly></td></tr> -->
						<tr><td>Operation Date</td><td><input id="operationdate" class="myInputs date-picker" readonly></td></tr>
						<tr><td>OperationTime</td><td ><input id="operationtime" class="myInputs input-small" readonly></td></tr>
						<tr><td>Equipment required</td><td ><?php echo $equipmenttodeliver; ?></td></tr>
						<tr><td>Delivery type</td><td ><select class="myInputs" id="deliverytype"><option> Delivery </option><option> Consignment </option></select></td></tr>
						<tr><td>Rep attendance</td><td ><select class="myInputs" id="repattendance"><option> Yes </option><option> No </option></select></td></tr>
						<tr><td>Additional Notes</td><td ><textarea class="myInputs" name="additionalnotes" cols="14" rows="5" id="additionalnotes"></textarea></td></tr>
					</tbody>
					</table>
				</div>
			</div>
			

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
		
		<div>
			<button id="createbutton" class="btn btn-success col-lg-offset-2" data-toggle="modal" data-target="#confirm-save">
		   		Create
			</button>
		
			<!--confirm modal-->
			<div class="modal fade" id="confirm-save" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <div class="modal-header">
			                <h4>Confirm event details</h4>
			            </div>
			            <div class="modal-body">
			               Are you sure you want to create this event?
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			                <a class="btn btn-success btn-ok" onclick="saveEvent()" data-dismiss="modal">Create</a>
			            </div>
			        </div>
			    </div>
			</div><!--  end confirm modal -->
			<!--</form>-->
		</div>
		<br/><br/><br/>
						
		</div>
	

	<script type="text/javascript">
		//$('#dataNOTSaved').hide();
		//$('#dataSaved').hide();

		
	
		// $(document).bind('DOMSubtreeModified', function () {
		
		//        alert("test");
		   
		// });

		var hospitalname = "";
		var doctorname = "";


		$('#createbutton').attr("disabled","disabled"); 
		
		
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


		 var userid = "";
		 function setID(userID) {
		    userid = userID;
		   
		}

		

		function setHospitaltable(){	        
				var table = new $('#hospitalTable').DataTable();
		
				
				// table1.column(3).visible(false); //hide doctor name col
				// table1.column(5).visible(false); //hide required equipmet col
	     
				
				$('#hospitalTable tbody').on( 'click', 'tr', function () {	        	          
				    selectedRow = $(this);	 
				    hospitalname = selectedRow[0].children[1].innerHTML; 
				    document.getElementById("hospitalname").innerHTML=hospitalname+'<a data-toggle="modal" data-target="#hospitallist">    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
					//following code enables create button 
				
					if ((hospitalname.length > 0) && (doctorname.length > 0)) {
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
				    document.getElementById("doctorname").innerHTML=doctorname+'<a data-toggle="modal" data-target="#doctorlist">    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
					
					//following code enables create button 
					if ((hospitalname.length > 0) && (doctorname.length > 0)) {
							$('#createbutton').removeAttr('disabled');
					};
				
					$('#doctorlist').modal('hide');	
			
				});
			}


		function populateHospitalTable(RTU_data,RTU_data1){

			 var newSpare = document.getElementById('hospitalTableBody');
			      var newHtml;
		       	  newHtml = "<tr><td>" + RTU_data  +"</td><td>" + RTU_data1  +"</td></tr>";
		          newSpare.innerHTML += newHtml;	          
			}

		function populateDoctorTable(RTU_data,RTU_data1){

			 var newSpare = document.getElementById('doctorTableBody');
			      var newHtml;
		       	  newHtml = "<tr><td>" + RTU_data  +"</td><td>" + RTU_data1  +"</td></tr>";
		          newSpare.innerHTML += newHtml;	          
			}
		
		function saveEvent(){
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
			var hospitalcell = document.getElementById('hospitalname').innerHTML;
	    	var hospital = hospitalcell.substr(0, hospitalcell.indexOf('<'));

			
			var doctorcell = document.getElementById('doctorname').innerHTML;
			var doctor = doctorcell.substr(0, doctorcell.indexOf('<'));
			//var deliverydate = document.getElementById('deliverydate').value;
			var operationdate = document.getElementById('operationdate').value;
	    	var operationtime = document.getElementById('operationtime').value;
	    	var equipmenttodeliver = document.getElementById('equipmenttodeliver').value;
	    	var deliverytype = document.getElementById('deliverytype').value;
	  		var repattendance = document.getElementById('repattendance').value;
	  		var additionalnotes = document.getElementById('additionalnotes').value;
	       
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
				      url: "../Functions/saveCreatedEvent.php",
				      data: {Organiser:username, Hospital:hospital, Doctor:doctor, Operationdate:operationdate, Operationtime:operationtime, Equipmenttodeliver:equipmenttodeliver, 
				      		Deliverytype:deliverytype, Repattendance:repattendance, Additionalnotes:additionalnotes},
				      success: function(data) {
				        
				        $('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
				        if(data == 1)   //if save is successfull
				        {
				        	$('button').addClass('hidden');
				        	$('#dataSaved').show();
				        	$('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
				        	
				        	//$('#dataNOTSaved').hide();
				        	
				        	
				        	//var mytime = setInterval(function(){ $('#dataSaved').hide();  clearInterval(mytime);}, 1800);

				        	var message = "New - Org:" + organiser + ", Hosp:" + hospital  + ", Equip:" + equipmenttodeliver + ", Date:" + operationdate + " " + operationtime;
				        	//console.log(message.length);
				        	
				        	$.ajax({   								//ajax call to insert data into DB on save
						      type: "POST",
						      url: "../Functions/sendMessageAjax.php",
						      data: {Type:"Event_Create",Data:message,Originator:userid},
						      success: function(data) {
						    	// console.log(data);
						    	 
						    	// console.log(data);
						    	// console.log(organiser);
						      }
						    });

				            
				        	//redirect to home page after 2 sec
				        	window.setTimeout(function(){
				        		window.location.href = "./home.php";
				        	}, 1500);


				        }else
				        {
				        	$('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
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
