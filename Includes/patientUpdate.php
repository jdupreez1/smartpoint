
<?php
	require_once '../Core/init.php';

	$user = new user(null,$_log);
	$_db = db::getInstance();

	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}

	if(!$user->hasPermission("Driver") && !$user->hasPermission("Rep") && !$user->hasPermission("Finance"))
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
	?>   

</head> 
		
<body>
	<?php 
		require_once 'slideMenu.php';  
		$myid = $user->data()->Id;
	?>


	<div class="container">

	<?php if(!isset($_GET['id'])){  ?>

		<div class="row" id="main1">
			<div class="col-xs-12 col-lg-10">
				<div id="dataSaved" class="alert alert-success" role="alert">Event was successfully saved</div>
				<div id="dataNOTSaved" class="alert alert-danger" role="alert">Event was not saved</div>
				<h3 class="col-xs-12"><span style="color:#00A7E1">Patient Details Update</span></h3>
              	<p>Please select event to update.</p>
				<div class="table-responsive">
					<table class="table" id="event_table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Organiser</th>
							    <th>Hospital</th>
							   <!-- <th>Doctor</th>  -->
								<th>Operation Date</th>
								<!--<th>Required Equip</th>   -->
							</tr>
						</thead>
						<tbody id="eventTableBody">
						</tbody> 
					</table>
				</div>
			</div>

		</div>

	<?php }else{ ?>  
		<div class="row" id="main2">
			<div class="col-xs-12 col-lg-10">
				<div id="dataSaved" class="alert alert-success" role="alert">Patient details sucessfully added</div>
				<div id="dataNOTSaved" class="alert alert-danger" role="alert">Failed to add patient details</div>
				<h3 class="col-xs-12"><span style="color:#00A7E1">Patient Details Update</span></h3>
              	<!-- <p>Event : <?php //echo $_GET["id"]?></p> -->
              	<p>Please complete patient details below and click Save.</p>
				
              	<table class="table " id="patientupdate_table">
					<thead>
						<tr>
							<th>Field</th>
						    <th>Input</th>
						    
						</tr>
					</thead>
					<tbody id="patientUpdateTableBody">
						<tr><td>Patient Name </td><td><input class="myInputs" type="text" id="patientname" value=""></td></tr>
						<tr><td>Patient Number </td><td><input class="myInputs" type="text" id="patientnumber" value=""></td></tr>
						<tr><td>Order number </td><td><input class="myInputs" type="text" id="ordernumber" value=""></td></tr>
					</tbody> 
				</table>
				<script type="text/javascript">
					var eventid = <?php echo $_GET['id'] ?>
				</script>

				<!-- <button class="btn btn-success" onclick="savePatientUpdate()"> Add Update </button> -->

				<button class="btn btn-success" data-toggle="modal" data-target="#confirm-save">
	   				SAVE
				</button>
			
				<!--confirm modal-->
				<div class="modal fade" id="confirm-save" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				    <div class="modal-dialog">
				        <div class="modal-content">
				            <div class="modal-header">
				                <h4>Confirm patient details</h4>
				            </div>
				            <div class="modal-body">
				               Are you sure these patient details are correct and that you would like to add them to the event?
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				                <a class="btn btn-success btn-ok" onclick="savePatientUpdate()" data-dismiss="modal">Add details</a>
				            </div>
				        </div>
				    </div>
				</div><!--  end confirm modal -->
				
			</div>

		</div>

		<?php } ?>

		<script>
			$('#dataNOTSaved').hide();
			$('#dataSaved').hide();
			var userid = "";
			 function setID(userID) {
			    userid = userID;
			   
			}							
		
		    function populateEventTable(RTU_data,RTU_data1,RTU_data2,RTU_data3){

			 var newRTU = document.getElementById('eventTableBody');
			      var newHtml;
		       	  newHtml = '<tr><td>' + RTU_data  +'</td><td>' + RTU_data1  +'</td><td>' + RTU_data2  +
		       	  			'</td><td>' + RTU_data3  +'</td></tr>';
		          newRTU.innerHTML += newHtml;	          
			}

			function setRTUtable(){	        
				var table1 = new $('#event_table').DataTable();
				var table2 = new $('#eventupdate_table').DataTable();
				
			//	table1.column(3).visible(false); //hide doctor name col
			//	table1.column(5).visible(false); //hide required equipmet col	     
				$('#event_table tbody').on( 'click', 'tr', function () {	        	          
				    selectedRow = $(this);	       
				    selectedRTU = selectedRow[0].children[0].innerHTML;
				   	console.log(selectedRTU);  
				  // 	$('#main1').hide();
				   //	$('#main2').show();		
				   var url = window.location.href;
				   url += '?id=' + selectedRTU;	
				   window.location.href = url;		 
				});
			}

			  function savePatientUpdate(){
			  		
				        
						var patientname = document.getElementById('patientname').value;
						var patientnumber = document.getElementById('patientnumber').value;
						var ordernumber = document.getElementById('ordernumber').value;
						console.log(patientname);
						console.log(patientnumber);
						console.log(ordernumber);
						
						if(patientname.length > 0)   
						{
						 $.ajax({   								//ajax call to insert data into DB on save
						      type: "POST",
						      url: "../Functions/savePatientUpdate.php",
						      data: {Eventid:eventid, Patientname:patientname, Patientnumber:patientnumber, Ordernumber:ordernumber },
						      success: function(data) {
						      	$('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
						        console.log(data);
						        if(data == 1)   //if save is successfull
						        {
						        	// $('#dataSaved').show();
						        	// $('#dataNOTSaved').hide();
						        	$('#dataSaved').show();
						        	$('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page

						        	//var mytime = setInterval(function(){ $('#dataSaved').hide(); location.reload(); clearInterval(mytime);}, 1800);
						        	
						        	$.ajax({   								//ajax call to insert data into DB on save
								      type: "POST",
								      url: "../Functions/getOriginator.php",
								      data: {Event:eventid},
								      success: function(data) {
								    	 
								    	  var data_rx = JSON.parse(data);
								    	 var message = "Patient Details - Org:" + data_rx["Name"] + ", Patient:" + patientname  + ", Patient Nr:" + patientnumber + ", Order:" + ordernumber  ;
							        	//console.log(message.length);
							        	
							        	$.ajax({   								//ajax call to insert data into DB on save
									      type: "POST",
									      url: "../Functions/sendMessageAjax.php",
									      data: {Type:"Event_Patient_Update",Data:message,Originator:data_rx["Id"]},
									      success: function(data) {
									    	 
									    	 
									    	// console.log(data);
									    	// console.log(organiser);
									      }
									    });
								    	// console.log(organiser);
								      }
								    });
									


						        	//redirect to home page after 2 sec
						        	window.setTimeout(function(){
						        		window.location.href = "./home.php";
						        	}, 2500);

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
							var mytime = setInterval(function(){ $('#dataNOTSavedLimit').hide();  clearInterval(mytime); }, 4000);
						}
						
				    }


		//	$('#main2').hide();	   //hide update section

		</script>

	<!-- 	<input type="hidden" name="saved" value="1" />
		<button class="btn btn-success" onclick="xxx()"> SAVE </button> -->
		
				
	</div>

	

	<?php    //populate table with events
		if(!isset($_GET['id']))
		{				
			if($dbh = $_db->get('Event_Req', array('Status','<>','created','Status','<>','acked'))){    //get data from event table. No where statement required
				if($dbh->counts() > 0){
					foreach($dbh->results() as $key)
					{
						
						//get organiser name from organiser ID
						if($dbh2 = $_db->get('Users', array('Id', '=', $key->Organiser))){    
							foreach($dbh2->results() as $key2){ 
								$organisername = $key2->Full_Name;
							}						
						}

						//get hospital name from hospital ID
						if($dbh2 = $_db->get('Hospitals', array('Id', '=', $key->Hospital))){    
							foreach($dbh2->results() as $key2){ 
								$hospitalname = $key2->Name;
							}						
						}

						//get doctor name from doctor ID
					/*	if($dbh2 = $_db->get('Doctors', array('Id', '=', $key->Doctor))){    
							foreach($dbh2->results() as $key2){ 
								$doctorname = $key2->Name;
							}						
						}

						//get equipment description name from equipment ID ID
						if($dbh2 = $_db->get('Equipment_Sets', array('Id', '=', $key->Equipment_Required))){    
							foreach($dbh2->results() as $key2){ 
								$equipmentrequired = $key2->Description;
							}						
						}*/

						$operationdate = mb_substr($key->Operation_Date, 0, 16);

						//$saveddeliverydate = mb_substr($saveddeliverydate, 0, 10);


			
						//$details = $hospitalname . ", " . $doctorname;
						//echo "<script type='text/javascript'> populateEventTable('$hospitalname','$doctorname','$key->Operation_Date','$equipmentrequired','$edit_button'); </script>";
						//echo "<script type='text/javascript'> populateEventTable($key->Id,'$organisername','$hospitalname','$doctorname','$operationdate','$equipmentrequired'); </script>";
						echo "<script type='text/javascript'> populateEventTable($key->Id,'$organisername','$hospitalname','$operationdate'); </script>";

					}

				echo "<script type='text/javascript'> setRTUtable(); </script>";

					
				}else
				{
					echo "<div class='container'><div class='row'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>  Sorry, no applicable events found to update</div></div>";
					//echo "Nothing found in DB";
				}

			}
			else {
				echo "Could not read from DB";
			}
		}else
		{
			// this section was used to populate delivery update table with javascript i.e.
			//echo "<script type='text/javascript'> populateEventTable($key->Id,'$doctorname','$hospitalname','$equipmentrequired'); </script>";

			if($dbh = $_db->get('Event_Patient', array('Event_Req_Id','=',$_GET['id']))){    //get data from event table. No where statement required
				if($dbh->counts() > 0){
					$data = $dbh->last();
					
						
						
						echo "<script type='text/javascript'> populateEventTable($('#patientname').val('$data->Patient_Name'),$('#patientnumber').val('$data->Patient_Nr'),$('#ordernumber').val('$data->Order_Nr')); </script>";

					

				//echo "<script type='text/javascript'> setRTUtable(); </script>";

					
				}else
				{
					
					//echo "Nothing found in DB";
				}

			}
			else {
				echo "Could not read from DB";
			}
		}
	?>
<?php
	$myId = $user->data()->Id;
	echo "<script type='text/javascript'> setID($myId); </script>";
		?>
	
</body>	
	
</html>
