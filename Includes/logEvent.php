
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
		require_once 'headinfo.php'// this adds css, javascript, bootstrap
	?>   



</head> 
		
<body>
	<?php require_once 'slideMenu.php' ?> 
	<!-- <pre>
		<?php //rint_r($_POST); ?>
	</pre>
	<pre>
		<?php //print_r($user); ?>
	</pre> -->
	
	<div class="container col-lg-6">

		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading"><h4>Log event</h4></div>
			<div class="panel-body">
				<p> Step1 : Please log the event by completing the form below. When finished, click SAVE.</p>
				<table class="table table-hover">
				<thead>
					<!-- <tr><td>Field</td><td>Input</td></tr> -->
				</thead>
				<tbody>
					<form action="" method="post" role="form">						
					<?php
						//echo $user->data()->Username;
						// echo "<tr><td>Username</td><td><input type=\"text\" name=\"Username\" value=\"{$user->data()->Username}\"></td></tr>";
						// echo "<tr><td>Cell Number</td><td><input type=\"text\" name=\"Cellno\" value=\"{$user->data()->User_Cellphone}\"></td></tr>";
					?>
					<tr><td>Organizer</td><td id="organizer"><?php echo $user->data()->Username ?></td></tr>

				
    

					<?php
						//this section of code creates the hospital dropdown HTML
						$hospitaldropdown = "";
						$hospitaldropdown .="<select class=\"selectpicker\" name=\"hospital\">";
						if($dbh = $_db->get('Hospitals', array())){    //get data from company table. No where statement required
							if($dbh->counts() > 0){
								foreach($dbh->results() as $key){
									$hospitaldropdown .= "<option>{$key->Name}</option>";
								}
							}
						}
						$hospitaldropdown .="</select>";
					?>

					<?php
						//this section of code creates the doctor dropdown HTML
						$doctordropdown = "";
						$doctordropdown .="<select class=\"selectpicker\" name=\"doctor\">";
						if($dbh = $_db->get('Doctors', array())){    
							if($dbh->counts() > 0){
								foreach($dbh->results() as $key){
									$doctordropdown .= "<option>{$key->Name}</option>";
								}
							}
						}
						$doctordropdown .="</select>";
					?>

					

					<?php
						//this section of code creates the equipment dropdown
						$equipmenttodeliver = "";
						$equipmenttodeliver .="<select class=\"selectpicker\" id=\"equipmenttodeliver\">";
						if($dbh = $_db->get('Equipment_Sets', array())){    
							if($dbh->counts() > 0){
								foreach($dbh->results() as $key){
									$equipmenttodeliver .= "<option>{$key->Description}</option>";
								}
							}
						}
						$equipmenttodeliver .="</select>";
					?>


					<tr><td>Hosipital</td><td><?php echo $hospitaldropdown; ?></td></tr>
					<tr><td>Doctor</td><td><?php echo $doctordropdown; ?></td></tr>
					<tr><td>Delivery Date</td><td><input id="date-picker-1" type="text" class="date-picker form-control"size="15" name="deliverydate" value=""></td></tr>
					<tr><td>Operation Date</td><td><input id="date-picker-2" type="text" class="date-picker form-control"size="15" name="operationdate" value=""></td></tr>
					<tr><td>OperationTime</td><td><input id="timepicker2" size="5" type="text" name="operationTime" class="input-small" value=""></td></tr>
					<tr><td>Equipment to Deliver</td><td><?php echo $equipmenttodeliver; ?></td></tr>
					<tr><td>Rep attendance</td><td><select class="selectpicker" name="repattendance"><option> Yes </option><option> No </option></select></td></tr>
					<tr><td>Additional Notes</td><td><textarea name="additionalnotes" cols="14" rows="5"></textarea></td></tr>
				</tbody>
			</table>
			</div>

			<!-- Table -->
			


		</div>

		<h4>Step 2 : Please click SAVE to save the event.</h4>
		<input type="hidden" name="saved" value="1" />
		<button class="btn btn-success" onclick="saveEvent()"> SAVE </button>
		</form>
		
		<div><a href="home.php"><br/>Return to Home Page</a></div>
		<br/><br/><br/>

  
		


				
				
						
	</div>


	<script type="text/javascript">

	function saveEvent(){
				    	var equipmenttodeliver = document.getElementById('equipmenttodeliver').value;
				    	var organizer = document.getElementById('organizer').innerText;
				  
				    	console.log(equipmenttodeliver);
				    	console.log(organizer);
						
						
						// if(companyname.length > 0)   
						// {
						//  $.ajax({   								//ajax call to insert data into DB on save
						//       type: "POST",
						//       url: "../Functions/saveCompany.php",
						//       data: {Company_Name:companyname},
						//       success: function(data) {
						//         console.log(data);
						//         if(data == 1)   //if save is successfull
						//         {
						//         	$('#dataSaved').show();
						//         	$('#dataNOTSaved').hide();

						//         	var mytime = setInterval(function(){ $('#dataSaved').hide(); location.reload(); clearInterval(mytime);}, 4000);
						        	

						//         }else
						//         {
						//         	$('#dataNOTSaved').show();
						//         	$('#dataSaved').hide();
						//        		var mytime = setInterval(function(){ $('#dataNOTSaved').hide();  clearInterval(mytime); }, 4000);
						//         } 
						//       }
						//     });
						// }else
						// {
						// 	$('#dataNOTSavedLimit').show();
						// 	$('#dataSaved').hide();
						// 	var mytime = setInterval(function(){ $('#dataNOTSavedLimit').hide();  clearInterval(mytime); }, 4000);
						// }

				    }


        $('#timepicker2').timepicker({
            minuteStep: 1,
            template: 'dropdown',
            appendWidgetTo: 'body',
            showSeconds: false,
            showMeridian: false,
            //defaultTime: 'current'
        });
					        


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
			    console.log(today);
             	$('#date-picker-1').val(today);
	    		$('#date-picker-2').val(today);
			    $(".date-picker").datepicker({dateFormat: 'yy-mm-dd'} );

				$(".date-picker").on("change", function () {
				    var id = $(this).attr("id");
				    var val = $("label[for='" + id + "']").text();
				    $("#msg").text(val + " changed");
				});

				$('#basic_example_2').timepicker();

				 
			});

		
	</script>
	
</body>	
	
</html>
