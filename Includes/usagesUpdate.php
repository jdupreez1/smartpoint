
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
				<h3 class="col-xs-12"><span style="color:#00A7E1">Usages Update</span></h3>
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
				</div>
			</div>

		</div>

	<?php }else{ ?>  


		<!--equipment list modal-->
		<div class="modal fade" id="equipmentlist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4>Please click on equipment you would like to add to usages</h4>
		            </div>
		            <div class="modal-body">
		               <table class="table hover" id="sparesTable">
							<thead>
								<tr>
									<th>ID</th>
								    <th>Stock Code</th>
								     <th>Description</th>
								</tr>
							</thead>
							<tbody id="sparesTableBody">
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


		<div class="row" id="main2">
			<div class="col-xs-12 col-lg-6">
				<div id="dataSaved" class="alert alert-success" role="alert">Usages Update sucessfully added</div>
				<div id="dataNOTSaved" class="alert alert-danger" role="alert">Failed to add usages update</div>
				
				<h3 class="col-xs-12"><span style="color:#00A7E1">Usages Update</span></h3>
              	<!-- <p>Event : <?php //echo $_GET["id"]?></p> -->
              	<h5> Please complete patient details below. </h5>
				
              	<table class="table " id="patientupdate_table">
					<thead>
						<tr>
							<th>Field</th>
						    <th>Input</th>
						    
						</tr>
					</thead>
					<tbody id="patientUpdateTableBody">
						<tr><td>Patient Name </td><td><input class="myInputs" type="text" id="patientname"></td></tr>
						<tr><td>Patient Number </td><td><input class="myInputs" type="text" id="patientnumber"></td></tr>
						<tr><td>Order number </td><td><input class="myInputs" type="text" id="ordernumber"></td></tr>
					</tbody> 
				</table>

				<!-- <h5 class="col-xs-12"><span style="color:#00A7E1">Usages InputTable</span></h5> -->
              	
              	<h5> Please add usages below from equipment list. </h5>
				
              	<table class="table " id="usageupdate_table">
					<thead>
						<tr>
							<th>Stock Code</th>
							<th>Stock Description</th>
						    <th>QTY</th>						    
						</tr>
					</thead>
					<tbody id="usageUpdateTableBody">
						<!-- <tr><td><input type="text" value=""></td><td><input type="text" value=""></td></tr> -->
					</tbody> 
				</table>
				<script type="text/javascript">
					var eventid = <?php echo $_GET['id'] ?>

					$.ajax({   								//ajax call to insert data into DB on save
					      type: "POST",
					      url: "../Functions/getEventUpdatePagesInfo.php",
					      data: {Eventid: eventid},
					      success: function(data) {	
					    	var data_rx = JSON.parse(data);
					    	
				    		$('#patientname').val(data_rx[0]["Patient Name"]);
				    		$('#patientnumber').val(data_rx[0]["Patient Nr"]);
				    		$('#ordernumber').val(data_rx[0]["Order Nr"]);
				    		
					      }
					});


				</script>

				<!-- <button class="btn btn-success" onclick="saveUsageUpdate()"> Add Usages </button> -->
				<button id="addUpdateButton" class="btn btn-success" data-toggle="modal" data-target="#confirm-save">Add Update</button>
				<button id="equipmentListButton" class="btn btn-default" data-toggle="modal" data-target="#equipmentlist">Equipment List</button>
				<br/><br/>

			
				<!--confirm modal-->
				<div class="modal fade" id="confirm-save" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				    <div class="modal-dialog">
				        <div class="modal-content">
				            <div class="modal-header">
				                <h4>Confirm usage details</h4>
				            </div>
				            <div class="modal-body">
				               Are you sure you would these usages are correct and that you would like to add them to this event? 
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				                <a class="btn btn-success btn-ok" data-dismiss="modal" onclick="saveUsageUpdate()">Add Usages</a>
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
			var idnr = 0;
			var userid = "";
			 function setID(userID) {
			    userid = userID;
			   
			}
			
			function addline(spareId){
					
				    //create qty dropdown
				    qtydropdown = "";
				    var  qtydropdown = "<select id='selector"+idnr+"' width='80' style='width: 80px'>";				   
				    for (var i = 1; i <= 20; i++) {				    	
				    	qtydropdown += "<option>" + i + "</option>";
				     };			
				     qtydropdown += "</select>";
				     		          	
		          	var table = document.getElementById("usageUpdateTableBody");
				    var row = table.insertRow(-1);
				    row.id = "rownum"+idnr;
				    var cell1 = row.insertCell(0);
				    var cell2 = row.insertCell(1);
				    var cell3 = row.insertCell(2);
				    var cell4 = row.insertCell(3);

	   				$.ajax({
						url: '../Functions/getSpareDescriptions.php',                        
						type:"POST", 					
						dataType: 'json',                  				 
						data: {Spareid:spareId}, 
						success: function(data)          					 
						{					 
							cell1.innerHTML = data[0];
							cell2.innerHTML = data[1];								 
						}					 
					});

					cell3.innerHTML = qtydropdown;							
					cell4.innerHTML = "<button class='btn btn-warning btn-sm' onclick='deleteRow(this)'>Remove</button>";

					console.log(cell4.innerHTML);
					idnr++;
  
			}

			
			

			function deleteRow(r) {
			    var i = r.parentNode.parentNode.rowIndex;
			    document.getElementById("usageupdate_table").deleteRow(i);
			}

		     function populateEventTable(RTU_data,RTU_data1,RTU_data2,RTU_data3,RTU_data4,RTU_data5){

			 var newRTU = document.getElementById('eventTableBody');
			      var newHtml;
		       	  newHtml = '<tr><td>' + RTU_data  +'</td><td>' + RTU_data1  +'</td><td>' + RTU_data2  +
		       	  			'</td><td>' + RTU_data3  +'</td><td>' + RTU_data4  +'</td><td>' + RTU_data5  +'</td></tr>';
		          newRTU.innerHTML += newHtml;	          
			}

			function populateSparesTable(RTU_data,RTU_data1,RTU_data2){

			 var newSpare = document.getElementById('sparesTableBody');
			      var newHtml;
		       	  newHtml = '<tr><td>' + RTU_data  +'</td><td>' + RTU_data1  +'</td><td>' + RTU_data2  +'</td></tr>';
		          newSpare.innerHTML += newHtml;	          
			}


			function setRTUtable(){	        
				var table1 = new $('#event_table').DataTable();
				var table2 = new $('#sparesTable').DataTable();
				
				table1.column(3).visible(false); //hide doctor name col
				table1.column(5).visible(false); //hide required equipmet col
	     
				$('#event_table tbody').on( 'click', 'tr', function () {	        	          
				    selectedRow = $(this);	       
				    selectedRTU = selectedRow[0].children[0].innerHTML;
					
				   var url = window.location.href;
				   url += '?id=' + selectedRTU;	
				   window.location.href = url;		 
				});
				$('#sparesTable tbody').on( 'click', 'tr', function () {
					//alert("Successfully added");	        	          
				    selectedRow = $(this);	   
				    $(this).closest('tr').remove(); 
				    selectedSpare = selectedRow[0].children[0].innerHTML;
				   	//console.log(selectedSpare);  
				  	addline(selectedSpare);
				  	//selectedRow.deleteRow(0);
			
				});
			}

			  function saveUsageUpdate(){


						var usagestable = document.getElementById('usageUpdateTableBody');
						var count = $('#usageUpdateTableBody').children().length;
						var usagessaved = 0;
						var patientsaved = 0;
						//save usages 
					     for (i = 0; i < count; i++) {					  
					        stockcode = usagestable.rows[i].cells[0].innerHTML;
					        description = usagestable.rows[i].cells[1].innerHTML;					        
					        var e = usagestable.rows[i].cells[2].getElementsByTagName("select")[0];
        					var quantity = e.options[e.selectedIndex].value;
        			
					        $.ajax({   								//ajax call to insert data into DB on save
						      type: "POST",
						      async: false,
						      url: "../Functions/saveUsageUpdate.php",
						      data: {Eventid:eventid, Stockcode:stockcode, Quantity:quantity},
						      success: function(data) {						    
						       
						        if(data.trim() == 1)   //if save is successfull
						        {
						        	usagessaved = 1;
						        
						        	
						        }else
						        {
						        	usagessaved = 0;
						        	
						        	i = 999;
						        	
						        }
						        
						      }
						    });
							
						}
						//alert(usagessaved);
						//end of save usages

						//save patient details
						var patientname = document.getElementById('patientname').value;
						var patientnumber = document.getElementById('patientnumber').value;
						var ordernumber = document.getElementById('ordernumber').value;
						if ((patientname.length > 0) && 
							(patientnumber.length > 0)) {
							$.ajax({   								//ajax call to insert data into DB on save
						      type: "POST",
						      async: false,
						      url: "../Functions/savePatientUpdate.php",
						      data: {Eventid:eventid, Patientname:patientname, Patientnumber:patientnumber, Ordernumber:ordernumber },
						      success: function(data) {						    
						       
						        if(data.trim() == 1)   //if save is successfull
						        {
						        	patientsaved = 1;
						        
						        }else
						        {
						        	patientsaved = 0;						        						        	
						        }
						      }
						    });
						};
						//alert(patientsaved);
						//end save patient details
						var successful = 0;
						if(patientsaved == '1' && usagessaved == '1') { successful = 1};

						if(successful == 1){
							$('button').addClass('hidden');
							$('#equipmentListButton').addClass('hidden');
							$('#dataSaved').show();
				        	$('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page

					        	$.ajax({   								//ajax call to insert data into DB on save
							      type: "POST",
							      url: "../Functions/getOriginator.php",
							      data: {Event:eventid},
							      success: function(data) {
							    	 
							    	  var data_rx = JSON.parse(data);
							    	  
							    	 var message = "Usages Update - Org:" + data_rx["Name"] ;
						        	//console.log(message.length);
						        	
						        	$.ajax({   								//ajax call to insert data into DB on save
								      type: "POST",
								      url: "../Functions/sendMessageAjax.php",
								      data: {Type:"Event_Usages",Data:message,Originator:data_rx["Id"]},
								      success: function(data) {
								    	 
								    	//console.log(data);
								    	 
								      }
								    });
							    	// console.log(organiser);
							      }
							    });

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
									       }
									    });
								      }
								    });
					        

					        window.setTimeout(function(){
				        		window.location.href = "./home.php";
				        	}, 1500); 


						}else{
							$('#dataNOTSaved').show();
				        	$('#dataSaved').hide();
				       		var mytime = setInterval(function(){ $('#dataNOTSaved').hide();  clearInterval(mytime); }, 4000);
						}


						
				    }

		</script>

	</div>

	

	<?php    //populate table with events
		if(!isset($_GET['id']))
		{				
			if($dbh = $_db->get('Event_Req', array('Status','=','delivered'))){    //get data from event table. No where statement required
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
						if($dbh2 = $_db->get('Doctors', array('Id', '=', $key->Doctor))){    
							foreach($dbh2->results() as $key2){ 
								$doctorname = $key2->Name;
							}						
						}

						//get equipment description name from equipment ID ID
						if($dbh2 = $_db->get('Equipment_Sets', array('Id', '=', $key->Equipment_Required))){    
							foreach($dbh2->results() as $key2){ 
								$equipmentrequired = $key2->Description;
							}						
						}

						$operationdate = mb_substr($key->Operation_Date, 0, 16);
			
						$details = $hospitalname . ", " . $doctorname;
						//echo "<script type='text/javascript'> populateEventTable('$hospitalname','$doctorname','$key->Operation_Date','$equipmentrequired','$edit_button'); </script>";
						echo "<script type='text/javascript'> populateEventTable($key->Id,'$organisername','$hospitalname','$doctorname','$operationdate','$equipmentrequired'); </script>";

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
			if($dbh = $_db->get('Set_Spares', array())){    //get data from event table. No where statement required
				if($dbh->counts() > 0){
					foreach($dbh->results() as $key){
						echo "<script type='text/javascript'> populateSparesTable($key->Id, '$key->Stock_Code', '$key->Description' ); </script>";


					}
				}
			}
			
			echo "<script type='text/javascript'> populateEventTable($key->Id,'$doctorname','$hospitalname','$equipmentrequired'); </script>";
			echo "<script type='text/javascript'> setRTUtable(); </script>";

		}
	?>

	
</body>	
<?php
	$myId = $user->data()->Id;
	echo "<script type='text/javascript'> setID($myId); </script>";
?>
	
</html>
