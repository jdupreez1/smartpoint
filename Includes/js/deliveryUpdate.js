function getEventInfo(eventid){
	$.ajax({   								//ajax call to insert data into DB on save
	      type: "POST",
	      url: "../Functions/getEventInfo.php",
	      data: {Page: 'deliveryUpdate', Eventid: eventid},
	      success: function(data) {					    	 
	    	 
	    	//console.log(data);
	    	var data_rx = JSON.parse(data);
	    	//var usageList = "";
	
		 		//populate event Info
		 		//onsole.log(data_rx[0]["Equipment Description"]);
	    		$('#deliveredby').html(data_rx[0]["Full Name"]);
	    		$('#equipmentdescription').html(data_rx[0]["Equipment Description"]);
	    		$('#equipmentlist').html(" - " + data_rx[0]["Equipment Description"]);
	    		$('#eventcomments').html(data_rx[0]["Event Comments"]);
	    	 					 		
	      }
	});

}

function populateEventTable(RTU_data,RTU_data1,RTU_data2,RTU_data3,RTU_data4,RTU_data5){

 var newRTU = document.getElementById('eventTableBody');
      var newHtml;
   	  newHtml = '<tr><td>' + RTU_data  +'</td><td>' + RTU_data1  +'</td><td>' + RTU_data2  +
   	  			'</td><td>' + RTU_data3  +'</td><td>' + RTU_data4  +'</td><td>' + RTU_data5  +'</td></tr>';
      newRTU.innerHTML += newHtml;	          
}

function getEvents(eventstatus){
	$.ajax({   								//ajax call to insert data into DB on save
	      type: "POST",
	      url: "../Functions/getEvents.php",
	      data: {EventStatus: eventstatus},
	      success: function(data) {					    	 
	    	 
		    	//console.log(data);
		    	var data_rx = JSON.parse(data);
		    	//var usageList = "";

		 		//populate event Info
		 		//onsole.log(data_rx[0]["Equipment Description"]);
				// $('#deliveredby').html(data_rx[0]["Full Name"]);
				// $('#equipmentdescription').html(data_rx[0]["Equipment Description"]);
				// $('#equipmentlist').html(" - " + data_rx[0]["Equipment Description"]);
				// $('#eventcomments').html(data_rx[0]["Event Comments"]);
				//console.log(data_rx[0]["Event Id"]);
				if (data_rx.length > 0) {
					for (var i = data_rx.length - 1; i >= 0; i--) {			
						populateEventTable(data_rx[i]["Event Id"],data_rx[i]["Organiser"],data_rx[i]["Hospital"],data_rx[i]["Doctor"],data_rx[i]["Operation Date"],'xxx');
					}	
					setRTUtable();
				}else{
						$('#nodata').removeClass('hidden');

					// <div class='container'><div class='row'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>  Sorry, no applicable events found to update</div></div>";
					// Nothing found in DB";
				}    	 					 		
	      }
	});

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
	   var url = window.location.href;
	   url += '?id=' + selectedRTU;	
	   window.location.href = url;		 
	});
}

  function saveDeliveryUpdate(){
  			var table = document.getElementById('eventUpdateTableBody');
	    	//1-this section gets deliveredby details from table   
	        for (var r = 0, n = table.rows.length; r < n; r++) {
	            for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
	                //alert(table.rows[r].cells[c].innerHTML);
	            }
	        }
	        
	        var deliveredby = table.rows[0].cells[1].innerHTML;			  					  						  
			var equipmentdelivered = table.rows[1].cells[1].innerHTML;
			var setserial = document.getElementById('setserial').value;
			var cssdname = document.getElementById('cssdname').value;
			var delivereddate = document.getElementById('delivereddate').value;
			var deliveredtime = document.getElementById('deliveredtime').value;
			// console.log(eventid);
			// console.log(deliveredby);
			// console.log(equipmentdelivered);
			// console.log(setserial);
			// console.log(cssdname);
			// console.log(delivereddate);
			// console.log(deliveredtime);
	    	
			if(deliveredby.length > 0)   
			{
			 $.ajax({   								//ajax call to insert data into DB on save
			      type: "POST",
			      url: "../Functions/saveDeliveryUpdate.php",
			      data: {Eventid:eventid, Deliveredby:deliveredby, Cssdname:cssdname, Delivereddate:delivereddate, 
			      		Deliveredtime:deliveredtime, Equipmentdelivered:equipmentdelivered, Setserial:setserial },
			      success: function(data) {
			      	
			        console.log(data);
			        if(data == 1)   //if save is successfull
			        {
			        	$('button').addClass('hidden');
			        	$('#dataSaved').show();
			        	$('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
			        	$.ajax({   								//ajax call to insert data into DB on save
					      type: "POST",
					      url: "../Functions/getOriginator.php",
					      data: {Event:eventid},
					      success: function(data) {
					    	 var data_rx = JSON.parse(data);
					    	 var message = "Delivered - Driver:" + deliveredby + ", Date:" + delivereddate  + ", Time:" + deliveredtime + ", Equipment:" + equipmentdelivered + ", Originator:" + data_rx["Name"] ;
				        	$.ajax({   								//ajax call to insert data into DB on save
						      type: "POST",
						      url: "../Functions/sendMessageAjax.php",
						      data: {Type:"Event_Delivery",Data:message,Originator:data_rx["Id"]},
						      success: function(data) {
						    ;
						      }
						    });
					      }
					    });

			        	//redirect to home page after 2 sec
			        	window.setTimeout(function(){
			        		window.location.href = "./home.php";
			        	}, 2000);

			        }else
			        {
			        	$('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
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



//$(document).ready(function() {
$(window).load(function () {

	$('#dataNOTSaved').hide();
	$('#dataSaved').hide();
	$('#nodata').addClass('hidden');

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
 	$('#delivereddate').val(today);
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


	

	$('#deliveredtime').timepicker({
	    minuteStep: 5,
	    template: 'dropdown',
	    appendWidgetTo: 'body',
	    showSeconds: false,
	    showMeridian: false,
	    //defaultTime: 'current'
	});

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


	if (typeof eventid !== 'undefined') {
	getEventInfo(eventid);
    // the variable is defined
}
});
