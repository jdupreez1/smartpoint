
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
		$myname = $user->data()->Full_Name;
		$eventid = $_GET['id'];
	?>
	

	<div class="container">

	<?php if(!isset($_GET['id'])){  ?>

		<div class="row" id="main1">
			<div class="col-xs-12 col-lg-10">
				<div id="dataSaved" class="alert alert-success" role="alert">Event was successfully saved</div>
				<div id="dataNOTSaved" class="alert alert-danger" role="alert">Event was not saved</div>
				<h3 class="col-xs-12"><span style="color:#00A7E1">Refill Update</span></h3>
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
		<div class="row" id="main2">
			<div class="col-xs-12 col-lg-6">
				<div id="dataSaved" class="alert alert-success" role="alert">Refill details sucessfully added</div>
				<div id="dataNOTSaved" class="alert alert-danger" role="alert">Failed to add refill details</div>
				<h3 class="col-xs-12"><span style="color:#00A7E1">Refill Details Update</span></h3>
              	<!-- <p>Event : <?php //echo $_GET["id"]?></p> -->
              	<p>Please tick all the components that are being refilled and click Add Update.</p>
				
              	<table class="table" id="eventUsages">
					<thead>
						<tr>
							<th>Stock Code</th>
							<th>Description</th>
							<th>Amount used</th>
							<th>Amount Refilled</th>
						</tr>
					</thead>
					<tbody id="eventUsagesBody">											
					</tbody> 
				</table>
				<script type="text/javascript">
					var eventid = <?php echo $_GET['id'] ?>
				</script>

				<!-- <button class="btn btn-success" onclick="savePatientUpdate()"> Add Update </button> -->
				
				<button id="saveButton" class="btn btn-success" data-toggle="modal" data-target="#confirm-save">
	   				SAVE
				</button>
			
				<!--confirm modal-->
				<div class="modal fade" id="confirm-save" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				    <div class="modal-dialog">
				        <div class="modal-content">
				            <div class="modal-header">
				                <h4>Confirm refill details</h4>
				            </div>
				            <div class="modal-body">				             
								<input type="checkbox" id="confirmcheckbox" style="width: 20px"> By clicking this checkbox I, <?php echo $myname ?> , confirm that these refill details are correct and that I have addded the shown components to the set.<br/><br/><br/>
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				                <a id="submitButton" class="btn btn-success btn-ok" onclick="saveRefillUpdate()" data-dismiss="modal">Add details</a>
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
			$('#submitButton').attr("disabled","disabled"); 
			var chkbox = document.getElementById('confirmcheckbox');
			$('#confirmcheckbox').click(function(){
			    if(chkbox.checked == true){
			        $('#submitButton').removeAttr('disabled');
			    }
			    else {			    	
			        $('#submitButton').attr("disabled","disabled");  
			    }
			});

			var userid = "";
			 function setID(userID) {
			    userid = userID;
			   
			}	

			 function populateEventTable(RTU_data,RTU_data1,RTU_data2,RTU_data3,RTU_data4,RTU_data5){

			 var newRTU = document.getElementById('eventTableBody');
			      var newHtml;
		       	  newHtml = '<tr><td>' + RTU_data  +'</td><td>' + RTU_data1  +'</td><td>' + RTU_data2  +
		       	  			'</td><td>' + RTU_data3  +'</td><td>' + RTU_data4  +'</td><td>' + RTU_data5  +'</td></tr>';
		          newRTU.innerHTML += newHtml;	          
			}						
		
		    function populateUsageTable(RTU_data0,RTU_data1,RTU_data2,RTU_data3){

			 var newRTU = document.getElementById('eventUsagesBody');
			      var newHtml;
		       	  newHtml = '<tr><td>' + RTU_data0  +'</td><td>' + RTU_data1  +'</td><td>' + RTU_data2  +
		       	  			'</td><td>' + RTU_data3  +'</td></tr>';
		          newRTU.innerHTML += newHtml;	          
			}

			function setRTUtable(){	        
				var table1 = new $('#event_table').DataTable();
				var table2 = new $('#eventupdate_table').DataTable();
				
				table1.column(3).visible(false); //hide doctor name col
				table1.column(5).visible(false); //hide required equipmet col	     
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

			  function saveRefillUpdate(){
			  			
						var usagestable = document.getElementById('eventUsagesBody');
						var count = $('#eventUsagesBody').children().length;
						
					     for (i = 0; i < count; i++) {					  
					        stockcode = usagestable.rows[i].cells[0].innerHTML;
					        // description = usagestable.rows[i].cells[1].innerHTML;
					        // quantityused = 	usagestable.rows[i].cells[2].innerHTML;			        
					        var e = usagestable.rows[i].cells[3].getElementsByTagName("select")[0];
        					var quantityrefilled = e.options[e.selectedIndex].value;
        					
        					// console.log(description);
        					// console.log(quantityused);
        					console.log(eventid);
        					console.log(stockcode);
        					console.log(quantityrefilled);


							
					        $.ajax({   								//ajax call to insert data into DB on save
						      type: "POST",
						      url: "../Functions/saveRefillUpdate.php",
						      data: {Eventid:eventid, Stockcode:stockcode, Quantityrefilled:quantityrefilled},
						      success: function(data) {
						    
						        console.log(data);
						        if(data == 1)   //if save is successfull
						        {
						        	$('button').addClass('hidden');
						        	$('#dataSaved').show();
						        	$('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page

						        							  
						        }else
						        {
						        	$('#dataNOTSaved').show();
						        	$('#dataSaved').hide();
						       		var mytime = setInterval(function(){ $('#dataNOTSaved').hide();  clearInterval(mytime); }, 4000);
						        }
						        //redirect to home page after 2 sec
						        	window.setTimeout(function(){
						        		window.location.href = "./home.php";
						        	}, 1500); 
						      }
						    });
							
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
			if($dbh = $_db->get('Event_Req', array('Status','=','Used','Consignment','=','1'))){    //get data from event table. No where statement required
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

						//$saveddeliverydate = mb_substr($saveddeliverydate, 0, 10);


			
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
			// this section is used to populate refill update table with javascript

			//$qtydropdown = ""; //clear qty dropdown
			if($dbh = $_db->get('Event_Usage', array('Event_Req_Id','=', $eventid))){    //get data from event table. No where statement required
				if($dbh->counts() > 0){
					foreach($dbh->results() as $key){
												
						//$stockcode = str_pad($key->Stock_Code, 4, '0', STR_PAD_LEFT);
						$stockcode = $key->Stock_Code;
						//get stock description from stock code
						if($dbh2 = $_db->get('Set_Spares', array('Stock_Code','=', $stockcode))){    //get data from event table. No where statement required
							if($dbh->counts() > 0){
								foreach($dbh2->results() as $key2){									
										$stockdescription = $key2->Description;					
								}
							}
						}
						
						$amountused = $key->Qty_Used;

						$qtydropdown = '<select style="width: 80px">';
						for ($i = 0; $i <= $amountused; $i++) { 
							$qtydropdown .= '<option>' . $i . '</option>';
						}
						$qtydropdown .= '</select>';
				  		
						echo "<script type='text/javascript'> populateUsageTable('{$stockcode}', '{$stockdescription}', '{$amountused}', '{$qtydropdown}'); </script>";

					}
				}
			}


		}
	?>
<?php
	$myId = $user->data()->Id;
	echo "<script type='text/javascript'> setID($myId); </script>";
		?>
	
</body>	
	
</html>
