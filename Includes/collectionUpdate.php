
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
				<h3 class="col-xs-12"><span style="color:#00A7E1">Collection Update</span></h3>
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
			<div class="col-xs-12 col-lg-10">
				<div id="dataSaved" class="alert alert-success" role="alert">Collection update sucessfully added</div>
				<div id="dataNOTSaved" class="alert alert-danger" role="alert">Failed to add collection update</div>
				<h3 class="col-xs-12"><span style="color:#00A7E1">Collection Update</span></h3>
              	<!-- <p>Event : <?php //echo $_GET["id"]?></p> -->
              	<p>Please complete collection details below and click Add Update.</p>
				
              	<?php
					// //this section of code creates the equipment dropdown
					// $equipmentdelivered = "";
					// $equipmentdelivered .="<select class=\"selectpicker\" id=\"equipmentdelivered\">";
					// if($dbh = $_db->get('Equipment_Sets', array())){    
					// 	if($dbh->counts() > 0){
					// 		foreach($dbh->results() as $key){
					// 			$equipmentdelivered .= "<option>{$key->Description}</option>";
					// 		}
					// 	}
					// }
					// $equipmentdelivered .="</select>";
				?>
				
				<table class="table " id="eventupdate_table">
					<thead>
						<tr>
							<th>Field</th>
						    <th>Input</th>
						    
						</tr>
					</thead>
					<tbody id="eventUpdateTableBody">
						<tr><td>Collected by </td><td><?php echo $user->data()->Full_Name ?></td></tr>
						<tr><td>Date </td><td><input class="myInputs date-picker" id="collecteddate" readonly></td></tr>
						<tr><td>Time </td><td><input class="myInputs" id="collectedtime" readonly></td></tr>
						<tr><td>Used ? </td><td ><select class="myInputs selectpicker" id="used"><option>Yes</option><option>No</option></select></span></td></tr>
						<span type="hidden" value="<?php echo $_GET['id']?>">
					</tbody> 
				</table>
		
				<script type="text/javascript">
					var eventid = <?php echo $_GET['id'] ?>
				</script>

				<!-- <button class="btn btn-success" onclick="saveCollectionUpdate()"> Add Update </button> -->


				<button id="saveButton" class="btn btn-success" data-toggle="modal" data-target="#confirm-save">
	   				Add Update
				</button>
			
				<!--confirm modal-->
				<div class="modal fade" id="confirm-save" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				    <div class="modal-dialog">
				        <div class="modal-content">
				            <div class="modal-header">
				                <h4>Confirm collection details</h4>
				            </div>
				            <div class="modal-body">
				               Are you sure you would like to add this collection update to the event?
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				                <a class="btn btn-success btn-ok" data-dismiss="modal" onclick="saveCollectionUpdate()">Add Update</a>
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
			$('#dataNOTSavedLimit').hide();

			$('#collectedtime').timepicker({
	            minuteStep: 15,
	            template: 'dropdown',
	            appendWidgetTo: 'body',
	            showSeconds: false,
	            showMeridian: false,
	            //defaultTime: 'current'
        	});

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
             	$('#collecteddate').val(today);
	    		//$('#operationdate').val(today);
			    //$(".date-picker").datepicker({dateFormat: 'yy-mm-dd'} );


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

		    function populateEventTable(RTU_data,RTU_data1,RTU_data2,RTU_data3,RTU_data4,RTU_data5){

			 var newRTU = document.getElementById('eventTableBody');
			      var newHtml;
		       	  newHtml = '<tr><td>' + RTU_data  +'</td><td>' + RTU_data1  +'</td><td>' + RTU_data2  +
		       	  			'</td><td>' + RTU_data3  +'</td><td>' + RTU_data4  +'</td><td>' + RTU_data5  +'</td></tr>';
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

			  function saveCollectionUpdate(){
			  			var table = document.getElementById('eventUpdateTableBody');
				    	//1-this section gets deliveredby details from table   
				        for (var r = 0, n = table.rows.length; r < n; r++) {
				            for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
				                //alert(table.rows[r].cells[c].innerHTML);
				            }
				        }
				        
				        var collectedby = table.rows[0].cells[1].innerHTML;			  					  						  
						var collecteddate = document.getElementById('collecteddate').value;
						var collectedtime = document.getElementById('collectedtime').value;
						var used = document.getElementById('used').value;
						console.log(eventid);
						console.log(collectedby);
						console.log(collecteddate);
						console.log(collectedtime);
						console.log(used);
				    						
						

						if(collectedby.length > 0)   
						{
						 $.ajax({   								//ajax call to insert data into DB on save
						      type: "POST",
						      url: "../Functions/saveCollectedUpdate.php",
						      data: {Eventid:eventid, Collectedby:collectedby, Collecteddate:collecteddate, 
						      		Collectedtime:collectedtime, Used:used },
						      success: function(data) {
						    	
						        console.log(data);
						        if(data == 1)   //if save is successfull
						        {
						        	$('button').addClass('hidden');
						        	$('#dataSaved').show();
						        	$('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
						        	
						        	//$('#dataNOTSaved').hide();

						        	$.ajax({   								//ajax call to insert data into DB on save
								      type: "POST",
								      url: "../Functions/getOriginator.php",
								      data: {Event:eventid},
								      success: function(data) {
								    	 
								    	  var data_rx = JSON.parse(data);
								    	 var message = "Collect - Driver:" + collectedby + ", Date:" + collecteddate  + ", Time:" + collectedtime + ", Used:" + used + ", Originator:" + data_rx["Name"] ;
							        	//console.log(message.length);
							        	
							        	$.ajax({   								//ajax call to insert data into DB on save
									      type: "POST",
									      url: "../Functions/sendMessageAjax.php",
									      data: {Type:"Event_Collection",Data:message,Originator:data_rx["Id"]},
									      success: function(data) {
									    	 
									    	 
									    	 //console.log(data);
									    	// console.log(organiser);
									      }
									    });
								    	// console.log(organiser);
								      }
								    });


						        	//var mytime = setInterval(function(){ $('#dataSaved').hide(); location.reload(); clearInterval(mytime);}, 1800);
						        	//redirect to home page after 2 sec
						        	window.setTimeout(function(){
						        		window.location.href = "./home.php";
						        	}, 1500);

						        }else
						        {
						        	$('#dataNOTSaved').show();
						        	$('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
						        	
						        	//$('#dataSaved').hide();
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
			if($dbh = $_db->get('Event_Req', array('Status','=','used','Consignment','=','0'))){    //get data from event table. No where statement required
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
			// this section was used to populate delivery update table with javascript i.e.
			//echo "<script type='text/javascript'> populateEventTable($key->Id,'$doctorname','$hospitalname','$equipmentrequired'); </script>";


		}
	?>
<?php
	$myId = $user->data()->Id;
	echo "<script type='text/javascript'> setID($myId); </script>";
?>
	
</body>	
	
</html>
