<?php
	//ini_set('display_errors',1);  error_reporting(E_ALL);
	require_once '../Core/init.php';
	
	$user = new user(null,$_log);
	$_db = db::getInstance();
	
	//var_dump($logger);
	

	if(!$user->isLoggedIn()) {
		redirect::to('index.php');
	}	
	require_once 'headinfo.php';  // this adds css, javascript, bootstrap
	require_once 'slideMenu.php';  
		
 
	 


?>





<!DOCTYPE html>
<html>
<head>
	<title>Change the user group</title>

	<script type="text/javascript">
	userid = 0;
	function setID(userID) {
	    userid = userID;
	}

	function changeUserGroup(group){

		$.ajax({   								//ajax call to update driver_ack  DB on acknowledge
      type: "POST",
      url: "../Functions/changeUserGroup.php",   
      data: {Group:group,User:userid},
      success: function(data) {
         
        
          $('#result').html('user changed');
          var mytime = setInterval(function(){ $('#result').html('');  clearInterval(mytime);}, 2000);
          //redirect to home page after 2 sec
	    	window.setTimeout(function(){
	    		window.location.href = "./home.php";
	    	}, 2000);

	    	
        
      }
    });
	}

	</script>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-xs-6">
			<button class="btn btn-info" onclick="changeUserGroup(4)">Manager</button>	
			<button class="btn btn-info" onclick="changeUserGroup(3)">Finance</button>	
			<button class="btn btn-info" onclick="changeUserGroup(5)">Rep</button>	
			<button class="btn btn-info" onclick="changeUserGroup(6)">Driver</button>	
			<p id="result"> </p>


		</div>
	</div>
</div>

<?php
	$myid = $user->data()->Id;

	echo "<script type='text/javascript'> setID($myid); </script>";
?>

</body>
</html>