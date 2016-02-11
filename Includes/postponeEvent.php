
<?php
	require_once '../Core/init.php';

	$user = new user(null,$_log);
	$_db = db::getInstance();

	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
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
					    var date = new Date();
						date.setDate(date.getDate());
						//alert(date);

						$('.date-picker').datepicker({    //using JQUERY UI datepicker not bootstrap
							dateFormat: 'yy-mm-dd',
						    minDate: date

						});

						$(".date-picker").on("change", function () {
						    var id = $(this).attr("id");
						    var val = $("label[for='" + id + "']").text();
						    $("#msg").text(val + " changed");
						});

						


		 			});
		</script>


</head> 
		
<body>
	<?php require_once 'slideMenu.php'; ?> 
	
	<?php 
		 
		if($dbh = $_db->get('Event_Req', array("Id","=",$id))){    
				if($dbh->counts() > 0){
					foreach($dbh->results() as $key){
					
						$savedhospitalid = $key->Hospital;
						$saveddoctorid = $key->Doctor;
						$saveddeliverydate = $key->Delivery_Date;
						$savedoperationdateandtime = $key->Operation_Date;
						$savedequipmentid = $key->Equipment_Required;
						$saveddeliverytypevalue = $key->Consignment;
						$savedrepattend = $key->Rep_Attend;
						$savednotes = $key->Comments;
					}
				}
		}
		$saveddeliverydate = mb_substr($saveddeliverydate, 0, 10);
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
		

		

	?>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-lg-8 col-lg-offset-2">
				<div id="dataSaved" class="alert alert-success" role="alert">Event was successfully updated</div>
				<div id="dataNOTSaved" class="alert alert-danger" role="alert">Event could not be updated</div>
				<div id="eventdeleted" class="alert alert-success" role="alert">Event was successfully deleted</div>
				<div id="eventNotdeleted" class="alert alert-danger" role="alert">Event could not be deleted</div>

				<h3 class="col-xs-12"><span style="color:#00A7E1">Postpone event</span></h3>
              	<p>Please enter new operation date and time below and click Postpone Event.</p>
				<table class="table table-hover" id="mytable">
				<thead>
					<!-- <tr><td>Field</td><td>Input</td></tr> -->
				</thead>
				<tbody >
											
					<tr ><td >Organiser</td><td id="organiser" ><?php echo $user->data()->Full_Name ?></td></tr>
					<tr class="hidden" ><td >Username</td><td id="username" ><?php echo $user->data()->Username ?></td></tr>
					<tr><td>Hosipital</td><td id="hospital"></td></tr>
					<tr><td>Doctor</td><td id="doctor"></td></tr>
					<tr><td>New Operation Date</td><td><input id="operationdate" class="myInputs date-picker" readonly></td></tr>
					<tr><td>New Operation Time</td><td ><input id="operationtime" class="myInputs input-small" readonly></td></tr>
					
				</tbody>
			</table>
			</div>

			
			
			<script type="text/javascript">
				
						//set hospital name
						var hospital = document.getElementById('hospital');
						var savedhospitalname = "<?php echo $savedhospitalname ?>";
						hospital.innerHTML = savedhospitalname;
						//set doctor name
						var doctor = document.getElementById('doctor');
						var saveddoctorname = "<?php echo $saveddoctorname ?>";
						doctor.innerHTML = saveddoctorname;

						
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
		
		<button class="btn btn-success col-lg-offset-2" data-toggle="modal" data-target="#confirm-save">
	   		Postpone Event
		</button>

		<!--confirm potpone modal-->
		<div class="modal fade" id="confirm-save" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4>Confirm event details</h4>
		            </div>
		            <div class="modal-body">
		               Are you sure you want to postpone this event?
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		                <a class="btn btn-success btn-ok" onclick="updateEvent()" data-dismiss="modal">Update</a>
		            </div>
		        </div>
		    </div>
		</div><!--  end confirm modal -->

		
	
		

		</div>
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

		 

		function updateEvent(){
			var table = document.getElementById('mytable');
	    	//1-this section gets organiser details from table   
	        for (var r = 0, n = table.rows.length; r < n; r++) {
	            for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
	                //alert(table.rows[r].cells[c].innerHTML);
	            }
	        }
	        
	       

	        var organiser = table.rows[0].cells[1].innerHTML;
	        //var username = table.rows[1].cells[1].innerHTML;
	    	//1-end 

	    	var hospitalcell = document.getElementById('hospital').innerHTML;
	    	var hospital = hospitalcell.substr(0, hospitalcell.indexOf('<'));			
			var doctorcell = document.getElementById('doctor').innerHTML;
			var doctor = doctorcell.substr(0, doctorcell.indexOf('<'));
			
			//var deliverydate = document.getElementById('deliverydate').value;
			var newoperationdate = document.getElementById('operationdate').value;
	    	var newoperationtime = document.getElementById('operationtime').value;

	    	alert(newoperationdate);
	    	alert(newoperationtime);
	    	
			$.ajax({   								//ajax call to insert data into DB on save
			      type: "POST",
			      url: "../Functions/savePostponeEvent.php",
			      data: {Id:id, Newoperationdate:newoperationdate, Newoperationtime:newoperationtime},
			      success: function(data) {
			        
			        $('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
			        if(data == 1)   //if save is successfull
			        {
			        	// $('#dataSaved').show();
			        	// $('#dataNOTSaved').hide();
			        	$('#dataSaved').show();
				        $('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
			        	
			        	var mytime = setInterval(function(){ $('#dataSaved').hide();  clearInterval(mytime);}, 1800);
			        	

			        	
					    	 
					    	 
					    	// var message = "Postponed - Org:" + organiser + ", Hosp:" + hospital  + ", Equip:" + equipmenttodeliver + ", Date:" + operationdate + " " + operationtime;
				      //   	console.log(message.length);
				        	
				      //   	$.ajax({   								//ajax call to insert data into DB on save
						    //   type: "POST",
						    //   url: "../Functions/sendMessageAjax.php",
						    //   data: {Type:"Event_Update",Data:message,Originator:userid},
						    //   success: function(data) {
						    	 
						    	 
						    // 	// console.log(data);
						    // 	// console.log(organiser);
						    //   }
						    // });
					    	// console.log(organiser);
					     



					    	//redirect to home page after 2 sec
			        	window.setTimeout(function(){
			        		window.location.href = "home.php";
			        	}, 2000);
			        	

			        }else
			        {
			        	$('#dataNOTSaved').show();
			        	$('#dataSaved').hide();
			        	
			        	
			       		var mytime = setInterval(function(){ $('#dataNOTSaved').hide();  clearInterval(mytime); }, 4000);
			        } 
			      }
			    });
			
			
	    }


		</script>

			
</body>	
	
</html>
