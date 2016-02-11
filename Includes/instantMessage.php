
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
	<?php require_once 'slideMenu.php' ?> 
	

		

</head> 
		
<body>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div id = "Alert" class="hidden alert alert-danger" role="alert"></div>
				
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">

			<div class="col-xs-12">
			<h3 class="col-xs-12"><span style="color:#00A7E1">Send Instant Message</span></h3>
              	<p>Please select the recipient, type your message and click the desired option</p>
              	</br>
				<p><strong>Recipient Name:</strong></p>
				<input type="text" class="col-xs-4"  name="recipient" id="recipient"  />
				

			</div>
		</div><!--row div-->

		<div class="row">
			</br></br>
			<div class="col-xs-12">

			<p><strong>Message:</strong></p>
				<textarea   class="col-xs-4" cols="40" rows="5" name="message" id="message" ></textarea>

			</div>
		</div><!--row div-->

		<div class="row">
			</br></br>
			<div class="col-xs-12">

			<button class="btn btn-info" onclick="sendEmail()">Email</button>
			<button class="btn btn-info" onclick="sendPush()">Push</button>
			

			</div>
		</div><!--row div-->
			
	</div>  <!--container div-->
	

<script type="text/javascript">
	var username = '';
$('#recipient').devbridgeAutocomplete({
	serviceUrl: '../Autocomplete/users.php',
	lookupLimit: 8,
	autoSelectFirst: true,

	showNoSuggestionNotice: true,
	forceFixPosition:true,

	onSelect: function (suggestion) {
	   username = suggestion.data;

	}
});




function sendTweet(){
	var message = $("#message").val();
	
	//console.log(message);
	$.ajax({   								//ajax call to insert data into DB on save
      type: "POST",
      url: "../Functions/sendTweet.php",
      data: {Message:message},
      success: function(data2) {
        console.log(data2);
       
      }
    });

}

function sendPush(){
	var message = "Instant - " + $("#message").val();
	
	
	$.ajax({   								//ajax call to insert data into DB on save
      type: "POST",
      url: "../Functions/sendMessageAjax.php",
      data: {Type:"Instant",Data:message,Originator:username},
      success: function(data) {
      //	console.log(data);
      	var data_rx = JSON.parse(data);
      //	console.log(data_rx);
        if(data_rx['status'] == 1){
        	showAlert("Message sent","success");
        }
      //  console.log(data);
      }
    });


}

function sendEmail(){
	var message = $("#message").val();

	$.ajax({   								//ajax call to insert data into DB on save
      type: "POST",
      url: "../Functions/sendEmail.php",
      data: {Message:message,Username:username.trim()},
      success: function(data) {
       // console.log(data);
       if(data.trim() == 1){
        	showAlert("Message sent","success");
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


	
</body>	
	
</html>
