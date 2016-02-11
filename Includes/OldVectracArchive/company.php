
<?php
	require_once '../Core/init.php';
	$dbh = null;
	$user = new user(null,$_log);
	$_db = db::getInstance();
	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}
	if(!$user->hasPermission("Admin"))
	{
		redirect::to('../index.php');	
	}
?>

<html>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Vectrack Tracking</title>
	<?php require_once 'add_headinfo.php' ?> <!-- this adds css, javascript, bootstrap  -->
</head> 
		
<body>
	<?php require_once 'add_navbar.php' ?> <!-- this adds navbar -->

	<!-- This is START of the HTML Section when edit button is clicked -->
	<?php 
		// print_r($_POST);
		$editcompany =  $mycheck = !isset($_POST['editcompany']) ? 0 : $_POST['editcompany'];
		$didsave =  $mycheck = !isset($_POST['didsave']) ? 0 : $_POST['didsave'];
		$delete =  $mycheck = !isset($_POST['delcompany']) ? 0 : $_POST['delcompany'];
		if ($editcompany == 1) { ?>

		 	<div class="container">
		 		<div class="row">
				 	<div class='col-lg-6'>
						<h4> Step 1 : Please edit company name below and click save. </h4><br/>	
						<table  class="table table-hover"> 
							<tr><th>Field</th><th>Data</th></tr>
							<form action="" method="post" role="form">
								<?php 

									if($dbh = $_db->get('Company', array('Id','=',$_POST["companyid"]))){
										if($dbh->counts() > 0){
											foreach ($dbh->results() as $key) {
												echo "<tr><td>Company ID</td><td>{$_POST["companyid"]}</td></tr>";
												echo "<tr><td>Company Name</td><td><input type=\"text\" name=\"newcompanyname\" value=\"$key->Company_Name\"></td></tr>";
												echo "<input type=\"hidden\" name=\"companyid\" value=\"$key->Id\">";
											}
										}
									}
								?>

						</table>
					</div>
				</div>
					<input type="hidden" name="didsave" value="1">						
					<button type="submit" class="btn btn-primary">Save</button>				
				</form>
				<div><a href="company.php"><br/>Return to Company Page</a><br/><br/><br/><br/></div>
			</div>

		
	

	<!-- This is END of the HTML Section when edit button is clicked -->


	<!-- This is START of the HTML Section when save button is clicked -->
		<?php 
			 } elseif ($didsave == 1) { 
			

				$dbh = $_db->update('Company', $_POST["companyid"], array(
				'Company_Name' => $_POST["newcompanyname"] ));

				

				if ($dbh) {
					echo "<div class=\"container alert alert-success\" role=\"alert\">SUCCESSFULLY UPDATED DB</div>";
					# code...
				}
				echo "<div class=\"container\"><a href=\"company.php\"><br/>Return to Company Page</a><br/><br/><br/><br/></div>";
			
		?>
<!-- This is END of the HTML Section when save button is clicked -->

<!-- This is START of the HTML Section when delete button is clicked -->
		<?php 
			 } elseif ($delete == 1) { 
			
				$dbh = $_db->delete('Company', array('Id','=',$_POST["companyid"]));

				if ($dbh) {
					echo "<div class=\"container alert alert-success\" role=\"alert\">SUCCESSFULLY DELETED</div>";
					# code...
				} else {
					echo "<div class=\"container alert alert-danger\" role=\"alert\">COULD NOT DELETE COMPANY</div>";
				}
				echo "<div class=\"container\"><a href=\"company.php\"><br/>Return to Company Page</a><br/><br/><br/><br/></div>";
			} else {
		?>
<!-- This is END of the HTML Section when delete button is clicked -->



		<!-- <pre>
			<?php // print_r($_POST); ?>
		</pre> -->
			
		<div class="container">
			<?php echo "<br/><br/>" ?>
			<div class="col-xs-12 col-md-6" > 
				<h4>The table below displays all the configured companies.<br/><br/> Here you have the option to add a company, edit a company name or delete a company.<br/><br/></h4>
       
				<table class = "table" id="company_table">
					<thead>
						<tr>
						    <th>Id</th>
						    <th>Description</th>
						    <th>Action1</th>		
						    <th>Action2</th>	    
						</tr>
					</thead>
					<tbody 
						id="rtuTableBody">
					</tbody> 
				</table>
			</div> 

			<div class="container col-xs-12">
				<div class="row">      
			      	<div id="companydiv">
			                <br/><br/>To add a company, please type comapny name in text box and click add.  <br/> <input type="text" id="companyname" name="companyname" value="">
			                <br/>
			                <button class="btn btn-primary" onclick="savecompany()">Add</button>	  
			                <br/><br/><a href="home.php"><br/>Return to Home Page</a><br/><br/><br/>        
			        </div>	       
				</div>  


				<div class="row">
					<div id="dataSaved" class="alert alert-success" role="alert">Company successfully added</div>
					<div id="dataNOTSaved" class="alert alert-danger" role="alert">Company could not be added</div>
					<div id="dataNOTSavedLimit" class="alert alert-danger" role="alert">You did not enter a company name</div>
				</div>

				<script>
					$('#dataNOTSaved').hide();
					$('#dataSaved').hide();
					$('#dataNOTSavedLimit').hide();

				    function populateRTUTable(RTU_data,RTU_data2,RTU_data3,RTU_data4){

					 var newRTU = document.getElementById('rtuTableBody');
				       // newRTU.innerHTML = '';
				        var newHtml;
				       
				            
				              newHtml = '<tr><td>' + RTU_data  +'</td><td>' + RTU_data2  + '</td><td>' + RTU_data3  + '</td><td>' + RTU_data4 + '</td></tr>';
				              
				             newRTU.innerHTML += newHtml;
				          
				 			//setRTUtable();
					}

				    function savecompany(){
				    	var companyname = document.getElementById('companyname').value;
				    	console.log(companyname);
						
						
						if(companyname.length > 0)   
						{
						 $.ajax({   								//ajax call to insert data into DB on save
						      type: "POST",
						      url: "../Functions/saveCompany.php",
						      data: {Company_Name:companyname},
						      success: function(data) {
						        console.log(data);
						        if(data == 1)   //if save is successfull
						        {
						        	$('#dataSaved').show();
						        	$('#dataNOTSaved').hide();

						        	var mytime = setInterval(function(){ $('#dataSaved').hide(); location.reload(); clearInterval(mytime);}, 4000);
						        	

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



				</script>

			<?php    //populate table with companies
				
						
				if($dbh = $_db->get('Company', array())){    //get data from company table. No where statement required
					if($dbh->counts() > 0){
						foreach($dbh->results() as $key)
						{
							$edit_button =  "<form action=\"\" method=\"post\" role=\"form\">";
							$edit_button .= "<div class=\"form-group\">";
							$edit_button .= "<input type=\"hidden\" name=\"companyid\" value=\"{$key->Id}\">";
							$edit_button .= "<input type=\"hidden\" name=\"editcompany\" value=\"1\">";
							$edit_button .= "<button type=\"submit\" class=\"btn btn-primary\">Edit</button>";
							$edit_button .= "</form>" ;

							$del_button =  "<form action=\"\" method=\"post\" role=\"form\">";
							$del_button .= "<div class=\"form-group\">";
							$del_button .= "<input type=\"hidden\" name=\"companyid\" value=\"{$key->Id}\">";
							$del_button .= "<input type=\"hidden\" name=\"delcompany\" value=\"1\">";
							$del_button .= "<button type=\"submit\" class=\"btn btn-danger\">Delete</button>";
							$del_button .= "</form>" ;

							


							echo "<script type='text/javascript'> populateRTUTable($key->Id,'$key->Company_Name','$edit_button','$del_button'); </script>";
						}

					echo "<script type='text/javascript'> var table = new $('#company_table').DataTable(); </script>";
	 
						
					}else
					{
						echo "Nothing found in DB";
					}

				}
				else {
					echo "Could not read from DB";
				}
			?>
			
	
		</div>
		<?php } ?>

</body>	
	
</html>