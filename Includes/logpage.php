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

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Orchestrate</title>
		
	</head>
	<?php require_once 'headinfo.php'; ?>
	<body>
		<?php require_once 'navbar.php'; ?>
		

	

		<div class="container">
			
			<div class="row">
				
				<div class="col-xs-12">
					<table class="table table-hover" id="logTable"> 
						<thead>
						<tr><th>Date / Time</th><th>Level</th><th>Description</th></tr>
						</thead>
						<tbody id="logTableBody">
							
						
						</tbody>
					</table>
					<div class="row">
					<div class="col-xs-1">
						<button class ="btn btn-danger" onclick="clearLog()">Clear Log</button>
						<script type="text/javascript">

							function clearLog(){
								var r = confirm("Are you sure you want to delete all the lof files?");
								if (r == true) {
									   
									

									$.ajax({   								//ajax call to insert data into DB on save
								      type: "POST",
								      url: "../Functions/deleteLog.php",

								     // data: {coordinates:geoObj['coordinates'],radius:geoObj['radius'],type:geoObj['type'],rtuID:selectedRTU},
								      success: function(data) {
								      	
								        location.reload();
								        
								      }
								    });

								

							} else {
									  //do not clear log 
									}
							}

							</script>
					</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				 function populateRTUTable(data0,data01,data02){

				 	var newHtml = $('#logTableBody').html() + '<tr><td>' + data0 + '</td><td class = "text-center">' + data01 + '</td><td>' + data02 + '</td></tr>';
					 $('#logTableBody').html(newHtml);
					}

	</script>
					
	<?php

	 	$files = scandir('../Log');
	 	$line_of_text = [] ;
	 	echo "<script type='text/javascript'> $('#logTableBody').html(''); </script>";
	 	for($i = 2;$i < sizeof($files);$i++) {
		  	$file = fopen("../Log/$files[$i]", "r");
			
			while (!feof($file)) {
				$line_of_text =  str_replace("[","",explode('] ',fgets($file)));
				if(sizeof($line_of_text) == 3)
				{
					$line1 = $line_of_text[0];
					$line2 = $line_of_text[1];
					$line3 = explode(': ',$line_of_text[2]);
						
					


					$line4 = "";
					for($j = 0;$j<sizeof($line3);$j++)
					{
						if(ctype_digit($line3[$j]))
							$line3[$j] = (int)$line3[$j];

						if($j == sizeof($line3) - 1 )
							$line4 .= preg_replace( "/\r|\n/", "", $line3[$j]);
						else
							$line4 .= $line3[$j] . ": ";

					}
					

	
					echo "<script type='text/javascript'> populateRTUTable('$line1','$line2','$line4'); </script>";		
					//echo "<tr><td>$line_of_text[0]</td><td>$line_of_text[1]</td><td>$line_of_text[2]</td></tr>" ;   //echo log file lines into table		
				}
			}
			fclose($file);

		}
		
		echo "<script type='text/javascript'> var table = new $('#logTable').DataTable({paging: false}); </script>";
	?>

			 

	</body>
</html>


