
<?php
	require_once '../Core/init.php';

	$user = new user(null,$_log);
	$_db = db::getInstance();

	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}

	if(!$user->hasPermission("Finance"))
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
				<h3 class="col-xs-12"><span style="color:#00A7E1">Invoice Update</span></h3>
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
				<div id="dataSaved" class="alert alert-success" role="alert">Invoice update sucessfully added</div>
				<div id="dataNOTSaved" class="alert alert-danger" role="alert">Failed to add invoice update</div>
				<h3 class="col-xs-12"><span style="color:#00A7E1">Invoice Update</span></h3>
              	<!-- <p>Event : <?php //echo $_GET["id"]?></p> -->
              	<p>Please complete invoice details below and click Add Update.</p>
				
				<table class="table " id="eventupdate_table">
					<thead>
						<tr>
							<th>Field</th>
						    <th>Input</th>
						    
						</tr>
					</thead>
					<tbody id="eventUpdateTableBody">
						<tr><td>Invoiced By </td><td><input class="myInputs" id="invoicedby"></td></tr>
						<tr><td>Invoiced Number </td><td><input class="myInputs" id="invoicenumber"></td></tr>
						<tr><td>Invoiced Amount </td><td>R <input class="myInputs" id="invoiceamount" style="width:194px"></td></tr>
						<tr><td>Invoiced On </td><td><input class="myInputs date-picker" id="invoicedate" readonly></td></tr>
						<span type="hidden" value="<?php echo $_GET['id']?>">
					</tbody> 
				</table>
				
				<p>Please see additional event details below</p><br/>
				<table class="table " id="eventupdate_table">

					<thead>
						<!-- <tr>
							<th></th>
						    <th></th>						    
						</tr> -->
					</thead>
					<tbody id="eventUpdateTableBody">
		        		<tr><td>Patient Name: </td><td id="PatientNameRow"></td></tr>
		        		<tr><td>Patient No: </td><td id="PatientNoRow"></td></tr>
		        		<tr><td>Patient Order No: </td><td id="PatientOrderNoRow"></td></tr>
			        	<tr><td>Set Used : </td><td id="EquipmentRow"> </td></tr>
		        		<tr><td>Set Serial: </td><td id="SetserialRow"></td></tr>
		        		<tr><td>Usages: </td><td id="UsagesRow"></td></tr>
			        	<tr><td>Hospital: </td><td id="HospitalRow"> </td></tr>
			        	<tr><td>Doctor: </td><td id="DoctorRow"> </td></tr>
						<tr><td>Organiser: </td><td  id="OrganiserRow"> </td></tr>
		        		<tr><td>Operation Date:</td><td id="OperationDateRow"></td></tr>
						<span type="hidden" value="<?php echo $_GET['id']?>">
					</tbody> 
				</table>
		
				<script type="text/javascript"> //GET EVENT INFO


					var eventid = <?php echo $_GET['id'] ?>;
					$.ajax({   								//ajax call to insert data into DB on save
					      type: "POST",
					      url: "../Functions/getEventUpdatePagesInfo.php",
					      data: {Eventid: eventid},
					      success: function(data) {	
					    	var data_rx = JSON.parse(data);
					    	var usageList = "";
				    		$('#OrganiserRow').html(data_rx[0]["Organiser"]);
				    		$('#OperationDateRow').html(data_rx[0]["Operation Date"]);
				    		$('#HospitalRow').html(data_rx[0]["Hospital"]);
				    		$('#DoctorRow').html(data_rx[0]["Doctor"]);
				    		$('#EquipmentRow').html(data_rx[0]["Equipment"]);
				    		$('#SetserialRow').html(data_rx[0]["Set Serial"]);
				    		$('#PatientNameRow').html(data_rx[0]["Patient Name"]);
				    		$('#PatientNoRow').html(data_rx[0]["Patient Nr"]);
				    		$('#PatientOrderNoRow').html(data_rx[0]["Order Nr"]);
				    		for (var i = 0; i <= data_rx.length - 1 ; i++) {
      					 			usageList += data_rx[i]["Amount Used"] + " x ";
      					 			usageList += data_rx[i]["Used Description"] + "<br/>";
      					 			//console.log(data_rx.length);
      					 		};
      					 	$('#UsagesRow').html(usageList);
      					 	$('#invoicedby').val(data_rx[0]["Invoiced By"]);
      					 	$('#invoicenumber').val(data_rx[0]["Invoice Number"]);
      					 	$('#invoiceamount').val(data_rx[0]["Invoice Amount"]);
      					 	$('#invoicedate').val(data_rx[0]["Date Invoiced"].substring(0,10));
					      }
					});

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
				                <h4>Confirm invoice details</h4>
				            </div>
				            <div class="modal-body">
				               Are you sure you would like to add this invoice update to the event?
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				                <a class="btn btn-success btn-ok" data-dismiss="modal" onclick="saveInvoiceUpdate()">Add Update</a>
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

			// $('#collectedtime').timepicker({
	  //           minuteStep: 15,
	  //           template: 'dropdown',
	  //           appendWidgetTo: 'body',
	  //           showSeconds: false,
	  //           showMeridian: false,
	  //           //defaultTime: 'current'
   //      	});

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

			  function saveInvoiceUpdate(){
			  			// var table = document.getElementById('eventUpdateTableBody');
				    // 	//1-this section gets deliveredby details from table   
				    //     for (var r = 0, n = table.rows.length; r < n; r++) {
				    //         for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
				    //             //alert(table.rows[r].cells[c].innerHTML);
				    //         }
				    //     }
				        var invoicedby = document.getElementById('invoicedby').value;
						var invoicenumber = document.getElementById('invoicenumber').value;
						var invoiceamount = document.getElementById('invoiceamount').value;
						var invoicedate = document.getElementById('invoicedate').value;
						// console.log(invoicedby);
						// console.log(invoicenumber);
						// console.log(invoiceamount);
						// console.log(invoicedate);
					
				    						
						

						if(invoicedby.length > 0)   
						{
						 $.ajax({   								//ajax call to insert data into DB on save
						      type: "POST",
						      url: "../Functions/saveInvoiceUpdate.php",
						      data: {Eventid:eventid, Invoicedby : invoicedby, Invoicenumber : invoicenumber,
						      		 Invoiceamount : invoiceamount, Invoicedate : invoicedate },
						      success: function(data) {
						    	
						        console.log(data);
						        if(data == 1)   //if save is successfull
						        {
						        	$('button').addClass('hidden');
						        	$('#dataSaved').show();
						        	$('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
						        	
						        	//$('#dataNOTSaved').hide();

						      //   	$.ajax({   								//ajax call to insert data into DB on save
								    //   type: "POST",
								    //   url: "../Functions/getOriginator.php",
								    //   data: {Event:eventid},
								    //   success: function(data) {
								    	 
								    // 	  var data_rx = JSON.parse(data);
								    // 	 var message = "Collect - Driver:" + collectedby + ", Date:" + collecteddate  + ", Time:" + collectedtime + ", Used:" + used + ", Originator:" + data_rx["Name"] ;
							     //    	//console.log(message.length);
							        	
							     //    	$.ajax({   								//ajax call to insert data into DB on save
									   //    type: "POST",
									   //    url: "../Functions/sendMessageAjax.php",
									   //    data: {Type:"Event_Collection",Data:message,Originator:data_rx["Id"]},
									   //    success: function(data) {
									    	 
									    	 
									   //  	 //console.log(data);
									   //  	// console.log(organiser);
									   //    }
									   //  });
								    // 	// console.log(organiser);
								    //   }
								    // });


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

		</script>

	</div>

	<?php    //populate table with events
		if(!isset($_GET['id']))
		{				
			if($dbh = $_db->get('Event_Req', array('Status','=','closed'))){    //get data from event table. No where statement required
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
