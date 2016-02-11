
<?php
	require_once '../Core/init.php';

	$user = new user(null,$_log);
	$_db = db::getInstance();

	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}

	if(!$user->hasPermission("CompAdmin") )
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
	<?php require_once 'slideMenu.php' ?> 
	
	
		

</head> 
		
<body>
	
	<script type="text/javascript">

	function addRowHandlers() {
		var table;
		 for(var k = 0;k < 2 ; k++)
	    {
		    if(k == 0){
			   table = document.getElementById('GroupsTable');
		   
		    }
		    else{
		    	 table = document.getElementById('MethodsTable');
		    
		    }
	   
	    var rows = table.getElementsByTagName("tr");
	    for (i = 0; i < rows.length; i++) {
	        var currentRow = table.rows[i];
	        var createClickHandler = 
	            function(row) 
	            {
	                return function() { 
                                        var cell = row.getElementsByTagName("td")[0];
                                        var id = cell.innerHTML;
                                        setConfig(this);
                                 };
	            };

	        currentRow.onclick = createClickHandler(currentRow);
	    }
	    }
	}
		

	
	
	function setConfig(row){
			
		    var radioResults = {};
		   
		    	
		    	 for (var j = 1, col; col = row.cells[j]; j++) {
		    		 if(col.childNodes[0].value.split("-")[0] in radioResults ){ }else
		    		 {
		    			 radioResults[col.childNodes[0].value.split("-")[0]] = {};
		    		 }
			        if (col.childNodes[0].type == 'radio') {
				       
			            if (col.childNodes[0].checked == true) {

			                radioResults[col.childNodes[0].value.split("-")[0]][col.childNodes[0].value.split("-")[1]] = 1;
			            }else
			            {
			            	radioResults[col.childNodes[0].value.split("-")[0]][col.childNodes[0].value.split("-")[1]] = 0;

			            }        
			        }
			        if (col.childNodes[0].type == 'checkbox') {
					       
			            if (col.childNodes[0].checked == true) {
				            
			                radioResults[col.childNodes[0].value.split("-")[0]][col.childNodes[0].value.split("-")[1]] = 1;
			            }else
			            {
			            	radioResults[col.childNodes[0].value.split("-")[0]][col.childNodes[0].value.split("-")[1]] = 0;

			            }        
			        }
		    
		    }

		  
		
				 

		    $.ajax({   								//ajax call to insert data into DB on save
			      type: "POST",
			      url: "../Functions/saveNotificationConfig.php",
			      data: {Data:radioResults},
			      success: function(data) {
			    	 
			    	 
			    	  var result = $.trim(data);
			    	  if(result != "Notification config saved")
			    	  {
			    	  	showAlert(data,'danger');
			    	  }else
			    	  {
			    		
			    	  }
			      }
			    });


	}

	function showAlert(data,type){

		$('#Alert').html(data);
		$('#Alert').removeClass().addClass('alert alert-' + type);
		$('#Alert').show();
		var mytime = setInterval(function(){ $('#Alert').hide();  clearInterval(mytime); }, 3000);

	}

	

	</script>

	<div class="container">
		<div class="row">
			<div id = "Alert" class="hidden alert alert-danger" role="alert"></div>
				
			<div class=" col-xs-12 col-md-8">
			
			
			
			<h3 class="col-xs-12"><span style="color:#00A7E1">Event Notification Methods</span></h3>
              	<p>Please select the desired notification methods for the various events.</p>
              	</br>
              	
              	
              <div class="table-responsive">	
              <table class="table table-hover table-condensed table-bordered " >
              	<thead >
              	<tr >
              	 <th class="text-center" >Event</th>
              	
              	 <th class="text-center">Email</th>
              	 <th class="text-center">Push</th>
              	
              	</tr>
              	</thead>
              	
              	<tbody id="MethodsTable">
              	
              	 <?php 
              	 
              	 if($dbh2 = $_db->get('Company_Notification_Config', array())){
              	 	if($dbh2->counts() > 0){
              	 		
              	 		foreach($dbh2->results() as $key)
              	 		{
              	 			
              	 			
              	 			echo '<tr>
									<td>' . explode("_",$key->Event_Type)[0] . " " . explode("_",$key->Event_Type)[1] .'</td>
									
									<td ><input style="width:100%;margin:0 auto;text-align:center" type="radio" name="'. $key->Event_Type.'" value="' . $key->Id . '-Email"'. (($key->Email == 1)? "checked" :""). '></td>
									<td ><input style="width:100%;margin:0 auto;text-align:center" type="radio" name="'. $key->Event_Type.'" value="' . $key->Id . '-Push"'. (($key->Push == 1)? "checked" :""). '></td> 
								</tr>';	
              	 			
              	 		}             	 		
              	 		
              	 
              	 	}else
              	 	{
              	 			
              	 		 echo 'No data in Company_Notification_Config Table';
              	 
              	 	}
              	 }else 
              	 {
              	 	
              	 	echo 'cannot access Company_Notification_Config Table';
              	 	
              	 }
              	 
              	 
              	 ?>
              	
              	
				
              	
              	 </table>
              	 </div>
              	 </div>
              	 </div>
              	 <div class="row">
              	 	<div class="col-xs-12 col-md-8"> 
              	 
              	 <h3 class="col-xs-12"><span style="color:#00A7E1">User Group Notifications</span></h3>
              	 <p>Please select the desired notification methodsfor the different user groups.</p>
              	</br>
              	<div class="table-responsive">
              	 <table class="table table-hover table-condensed table-bordered" >
              
              	
              	<thead>
	              	<tr>
	              	 <th class="text-center">Event</th>
	              	 <th class="text-center">Originator</th>
	              	 <th class="text-center">Driver</th>
	              	 <th class="text-center">Rep</th>
	              	 <th class="text-center">Admin</th>
	              	 <th class="text-center">Manager</th>
	              	 <th class="text-center">Finances</th>
	              	 <th class="text-center">Guest</th>
	              	 
	              	</tr>
	              	
              	</thead>
              	
              	<tbody id="GroupsTable">
              	
              	
              	 <?php 
              	 
              	 if($dbh2 = $_db->get('Company_Notification_Config', array())){
              	 	if($dbh2->counts() > 0){
              	 		
              	 		foreach($dbh2->results() as $key)
              	 		{
              	 			
              	 			
              	 			echo '<tr>
									<td>' . explode("_",$key->Event_Type)[0] . " " . explode("_",$key->Event_Type)[1] .'</td>
									<td ><input style="width:100%;margin:0 auto;text-align:center" type="checkbox"  value="' . $key->Id . '-Originator" '. (($key->Originator == 1)? "checked" :""). ' ></td> 
									<td ><input style="width:100%;margin:0 auto;text-align:center" type="checkbox"  value="' . $key->Id . '-Driver"'. (($key->Driver == 1)? "checked" :""). '></td> 
		        					<td ><input style="width:100%;margin:0 auto;text-align:center" type="checkbox"  value="' . $key->Id . '-Rep" '. (($key->Rep == 1)? "checked" :""). ' ></td> 
									<td ><input style="width:100%;margin:0 auto;text-align:center" type="checkbox"  value="' . $key->Id . '-Admin"'. (($key->Admin == 1)? "checked" :""). '></td> 
		                			<td ><input style="width:100%;margin:0 auto;text-align:center" type="checkbox"  value="' . $key->Id . '-Manager" '. (($key->Manager == 1)? "checked" :""). ' ></td> 
									<td ><input style="width:100%;margin:0 auto;text-align:center" type="checkbox"  value="' . $key->Id . '-Finances"'. (($key->Finances == 1)? "checked" :""). '></td>
									<td ><input style="width:100%;margin:0 auto;text-align:center" type="checkbox"  value="' . $key->Id . '-Guest"'. (($key->Guest == 1)? "checked" :""). '></td> 
								</tr>';	
              	 			
              	 		}             	 		
              	 		
              	 
              	 	}else
              	 	{
              	 			
              	 		 echo 'No data in Company_Notification_Config Table';
              	 
              	 	}
              	 }else 
              	 {
              	 	
              	 	echo 'cannot access Company_Notification_Config Table';
              	 	
              	 }
              	 
              	 
              	 ?>
              	 
              	
              	
              	
              	</tbody>
              
              
              </table>
				</div>

			</div>
		</div><!--row div-->

		

		
			
	</div>  <!--container div-->
	

<script type="text/javascript">


window.onload = addRowHandlers();



	
</script>


	
</body>	
	
</html>
