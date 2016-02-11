
	var userid;
	var name;
	var repFeed;
	var driverFeed;
	var managerFeed;
	var financeFeed;
	var driver;
	var eventid;
	
	$(document).ready(function() {
		refreshCal();
		setTable();			        
	});

	function resizeCalendar(calendarView) {
	    if(calendarView.name === 'agendaWeek' || calendarView.name === 'agendaDay') {
	        // if height is too big for these views, then scrollbars will be hidden
	        calendarView.setHeight(9999);
	    }
	}
	function setID(userID,Name) {
	    userid = userID;
	    name = Name;
	}
	function setRep(active) {
	    repFeed = active;
	}
	function setDriver(active) {
	    driverFeed = active;
	}
	function setManager(active) {
	    managerFeed = active;
	}
	function setFinance(active) {
	    financeFeed = active;
	}

	function setTable(){
		$('#modalTable tbody').on( 'click', 'tr', function () {	        	          
			    selectedRow = $(this);	       
			    selectedRowValue = selectedRow[0].children[0].innerHTML;
			   
			   	switch(selectedRowValue){				//check which row in modal1 was selected and direct to that page

			   		case 'Event Update':
			   			window.location.href = "../Includes/eventUpdate.php?id=" + $('#eventClickModal').val();
			   		break;
			   		case 'Delivery Update':
			   			window.location.href = "../Includes/deliveryUpdate.php?id=" + $('#eventClickModal').val();
			   		break;
			   		case 'Collection Update':
			   			window.location.href = "../Includes/collectionUpdate.php?id=" + $('#eventClickModal').val();
			   		break;		   		
			   		case 'Usages Update':
			   			window.location.href = "../Includes/usagesUpdate.php?id=" + $('#eventClickModal').val();
			   		break;
			   		case 'Patient Details Update':
			   			window.location.href = "../Includes/patientUpdate.php?id=" + $('#eventClickModal').val();
			   		break;
			   		case 'Refill Update':
			   			window.location.href = "../Includes/refillUpdate.php?id=" + $('#eventClickModal').val();
			   		break;
			   		case 'Invoice Update':
			   			window.location.href = "../Includes/invoiceUpdate.php?id=" + $('#eventClickModal').val();
			   		break;
			   		case 'Event Details':
			   			$('#eventClickModal').modal('hide');
			   			$('#eventDetailsClickModal').modal('show');

			   		break;
			   	}

			   	 $('#eventClickModal').modal('hide');
			   		 
			});

	}

	function refreshCal(){
			var firstHour = new Date().getUTCHours() + 2;
		    // page is now ready, initialize the calendar...
			    $('#calendar').fullCalendar({
			    	
			    	height: $(document).height() * 0.90,
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},
					allDaySlot:false,
					defaultView: 'agendaDay',
					firstHour: firstHour,
					editable: false,
					 eventLimit: 3,				
					loading: function(bool) {
						  if (bool) 
							  myApp.showPleaseWait();
						  else
							  myApp.hidePleaseWait();					 					  
						},
					eventSources: [
				        // your JSON event source
				        {
				            url: '../Functions/calendarFeedRepAck.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: repFeed
				            },
				            color: '#99C4E0',    // an option!
				            textColor: 'black'  // an option!
				        },

				        {
				            url: '../Functions/calendarFeedDriver.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: driverFeed
				            },
				            color: 'orange',    // an option!
				            textColor: 'black'  // an option!
				        },
				        {
				            url: '../Functions/calendarFeedDriver.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: repFeed
				            },
				            color: 'orange',    // an option!
				            textColor: 'black'  // an option!
				        },

				        {
				            url: '../Functions/calendarFeedDriverNotAck.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: driverFeed
				            },
				            color: 'red',    // an option!
				            textColor: 'black'  // an option!
				        },

				        {
				            url: '../Functions/calendarFeedRepNotAck.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: repFeed
				            },
				            color: 'red',    // an option!
				            textColor: 'black'  // an option!
				        },

				        {
				            url: '../Functions/calendarFeedRepDelivered.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: repFeed
				            },
				            color: 'green',    // an option!
				            textColor: 'black'  // an option!
				        },
				        {
				            url: '../Functions/calendarFeedDriverDelivered.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: driverFeed  
				            },
				            color: 'green',    // an option!
				            textColor: 'black'  // an option!
				        },

				        {
				            url: '../Functions/calendarFeedRepCollected.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: repFeed
				            },
				            color: 'grey',    // an option!
				            textColor: 'black'  // an option!
				        }/*,
				        {
				            url: '../Functions/calendarFeedRepFilled.php',
				            cache: false,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: repFeed
				            },
				            color: 'grey',    // an option!
				            textColor: 'black'  // an option!
				        }*/,

				        {
				            url: '../Functions/calendarFeedRepToBeCollected.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: repFeed
				            },
				            color: 'maroon',    // an option!
				            textColor: 'black'  // an option!
				        }
				        ,

				        {
				            url: '../Functions/calendarFeedDriverToBeCollected.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: driverFeed
				            },
				            color: 'maroon',    // an option!
				            textColor: 'black'  // an option!
				        }
				        ,

				        {
				            url: '../Functions/calendarFeedRepToBeFilled.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: repFeed
				            },
				            color: '#FF0066',    // an option!
				            textColor: 'black'  // an option!
				        }
				        ,

				        {
				            url: '../Functions/calendarFeedDriverToBeFilled.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: driverFeed
				            },
				            color: '#FF0066',    // an option!
				            textColor: 'black'  // an option!
				        },
				        {
				            url: '../Functions/calendarFeedAll.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: managerFeed
				            },
				            color: '#99C4E0',    // an option!
				            textColor: 'black'  // an option!
				        },
				        {
				            url: '../Functions/calendarFeedAll.php',
				            cache: true,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: financeFeed
				            },
				            color: '#99C4E0',    // an option!
				            textColor: 'black'  // an option!
				        }

				        // your ajax event source
				        
				    ],
				    eventClick: function(calEvent, jsEvent, view) {
	 
					       eventid = calEvent.id;             		//get db id for the cicked event
					      
					       	$('#eventClickModal').val(eventid);	 	//show modal and pass id
					   		
						   eventstatus = calEvent.status;				 
					       consignment = calEvent.consignment;


					    //##THE FOLOWING CODE GETS EVENTS INFORMATION FOR MODAL2.

					    	$.ajax({   								//ajax call to insert data into DB on save
							      type: "POST",
							      url: "../Functions/getEventInfo.php",
							      data: {Page: 'Home', Eventid: eventid},
							      success: function(data) {					    	 
							    	 
							    	//console.log(data);
							    	var data_rx = JSON.parse(data);
							    	var usageList = "";
							
	      					 		//populate event Info
							    	$('#EventLoggedRow').html(data_rx[0]["Event Logged"]);
							    	

	      					 		//populate delivery Info
	      					 		$('#CSSDNameRow').html(data_rx[0]["CSSD Name"]);
	      					 		$('#SetserialRow').html(data_rx[0]["Set Serial"]);
	      					 		$('#DeliveryTimeRow').html(data_rx[0]["Delivery Time"]);
	      					 		$('#DeliveryLoggedRow').html(data_rx[0]["Delivery Logged"]);
	      					 		
	      					 		//populate Usage Info
	      					 		$('#PatientNameRow').html(data_rx[0]["Patient Name"]);
	      					 		$('#PatientNoRow').html(data_rx[0]["Patient Nr"]);
	      					 		$('#PatientOrderNoRow').html(data_rx[0]["Order Nr"]);
	      					 		for (var i = 0; i <= data_rx.length - 1 ; i++) {
	      					 			usageList += data_rx[i]["Amount Used"] + " x ";
	      					 			usageList += data_rx[i]["Used Description"] + "<br/>";
	      					 			//console.log(data_rx.length);
	      					 		};
	      					 		$('#UsagesRow').html(usageList);
	      					 		$('#UsageLoggedRow').html(data_rx[0]["Usage Logged"]);

	      					 		//populate Collection Info
	      					 		$('#CollectedByRow').html(data_rx[0]["Collected By"]);
	      					 		$('#CollectedDateRow').html(data_rx[0]["Collection Date"]);
	      					 		$('#CollectedTimeRow').html(data_rx[0]["Collection Time"]);
	      					 		$('#EquipmentUsedRow').html(data_rx[0]["Used"]);
	      					 		$('#CollectionLoggedRow').html(data_rx[0]["Collection Logged"]);

	      					 		//populate Invoice Info
	      					 		$('#InvoiceByRow').html(data_rx[0]["Invoiced By"]);
	      					 		$('#InvoiceNumberRow').html(data_rx[0]["Invoice Number"]);
	      					 		$('#InvoiceAmountRow').html("R " + data_rx[0]["Invoice Amount"]);
	      					 		$('#DateInvoicedRow').html(data_rx[0]["Date Invoiced"].substring(0,10));
	      					 		$('#InvoicedLoggedRow').html(data_rx[0]["Invoice Logged"]);      					 		
							      }
							});

					    //##END OF GETS EVENTS INFORMATION

					   
					       		
						    //**THE FOLLOWING CODE HIDES THE UPDATE SECTIONS WHICH IS NOT APPLICABE TO THE CURRENT EVENT STATUS*******************************************
					    				
							$('#deliveryupdatebuttn').addClass('hidden');
							$('#usagesupdatebuttn').addClass('hidden');
							$('#collectionupdatebuttn').addClass('hidden');
							$('#refillupdatebuttn').addClass('hidden');
							$('#patientupdatebuttn').addClass('hidden');
							$('#invoiceupdatebuttn').addClass('hidden');

						if(!managerFeed && !financeFeed){
							$('#deliveryupdatebuttn').removeClass('hidden');
							$('#usagesupdatebuttn').removeClass('hidden');
							$('#collectionupdatebuttn').removeClass('hidden');
							$('#refillupdatebuttn').removeClass('hidden');
							$('#patientupdatebuttn').removeClass('hidden');
							switch(eventstatus){				

								case 'created':
									$('#deliveryupdatebuttn').addClass('hidden');
									$('#usagesupdatebuttn').addClass('hidden');
									$('#collectionupdatebuttn').addClass('hidden');
									$('#refillupdatebuttn').addClass('hidden');
									$('#patientupdatebuttn').addClass('hidden');
									$('#eventClickModal').modal('show');
								break;

								case 'acked':
									$('#usagesupdatebuttn').addClass('hidden');
									$('#collectionupdatebuttn').addClass('hidden');
									$('#refillupdatebuttn').addClass('hidden');
									$('#patientupdatebuttn').addClass('hidden');
									$('#eventClickModal').modal('show');
								break;

								case 'delivered':
									$('#deliveryupdatebuttn').addClass('hidden');
									$('#collectionupdatebuttn').addClass('hidden');
									$('#refillupdatebuttn').addClass('hidden');
									
									$('#eventClickModal').modal('show');
								break;

								case 'used':
									$('#deliveryupdatebuttn').addClass('hidden');
									$('#usagesupdatebuttn').addClass('hidden');
									if (consignment == "Yes") {
										$('#collectionupdatebuttn').addClass('hidden');
									} else {								
										$('#refillupdatebuttn').addClass('hidden');

									}
									
									$('#eventClickModal').modal('show');
									
								break;

								case 'closed':
									$('#deliveryupdatebuttn').addClass('hidden');
									$('#usagesupdatebuttn').addClass('hidden');
									$('#collectionupdatebuttn').addClass('hidden');
									$('#refillupdatebuttn').addClass('hidden');
									
									$('#eventClickModal').modal('show');
								break;
							} 
						} if(financeFeed) {

							switch(eventstatus){				

								case 'delivered':
									
									$('#patientupdatebuttn').removeClass('hidden');
									$('#eventClickModal').modal('show');
								break;

								case 'used':
									
									$('#patientupdatebuttn').removeClass('hidden');
									$('#invoiceupdatebuttn').removeClass('hidden');
									$('#eventClickModal').modal('show');
									
								break;

								case 'closed':
									
									$('#patientupdatebuttn').removeClass('hidden');
									$('#invoiceupdatebuttn').removeClass('hidden');
									$('#eventClickModal').modal('show');
								break;
								default:$('#eventClickModal').modal('show');
								break;
							}

						}else if(managerFeed){
					   			$('#eventDetailsClickModal').modal('show');	 	//show modal and pass id
					   	}
	   			       	//********END*****************************************

				       // alert('Event: ' + calEvent.title);
				     	$('#ackBtn').addClass('hidden');
				     	$('#ackBtn2').addClass('hidden');
				     	$('#editBtn').addClass('hidden');
				     	$('#editBtn2').addClass('hidden');
				     	$('#deleteBtn').addClass('hidden');
				     	$('#deleteBtn2').addClass('hidden');
				     	$('#unAckBtn').addClass('hidden');     //show button if no driver is assigned
				     	$('#unAckBtn2').addClass('hidden');     //show button if no driver is assigned

				     	
				       if(calEvent.type != "NotAck"){					//if driver already acked, show name
				       		driver = calEvent.driver_ack; 
				        	$('.modal-body #driverName').html(driver);

					    }else
					    {
							$('.modal-body #driverName').html('None');
							$('#ackBtn').removeClass('hidden');     //show button if no driver is assigned
					    }
		
				        // change the border color just for fun
				        $(this).css('border-color', 'red');

				        //for modal 2 in case clicked
				        eventstatus_cap = eventstatus.charAt(0).toUpperCase() + eventstatus.slice(1);
				        $('#StatusRow').html(eventstatus_cap);
				        $('#OrganiserRow').html(calEvent.organiser);
				        $('#DeliveryDateRow').html(convertTimestamp(calEvent.delivery,0));
				        $('#OperationDateRow').html(convertTimestamp(calEvent.start,1));
				        $('#HospitalRow').html(calEvent.hospital);
				        $('#DoctorRow').html(calEvent.doctor);
				        $('#EquipmentRow').html(calEvent.equipment);
				        $('#RepAttendRow').html(calEvent.repAttend);
				        $('#ConsignmentRow').html(calEvent.consignment);
				        $('#CommentRow').html(calEvent.comments);
				        $('#DriverRow').html(calEvent.driver_ack);

				        if(calEvent.type == "NotAck")
				        {
				        	$('#ackBtn2').removeClass('hidden');     //show button if no driver is assigned
				        }
				        if(calEvent.organiserID == userid && calEvent.type == "NotAck"){
				        	$('#editBtn').removeClass('hidden');     //show button if no driver is assigned
				        	$('#editBtn2').removeClass('hidden');     //show button if no driver is assigned
				        	$('#deleteBtn').removeClass('hidden');     //show button if no driver is assigned
				        	$('#deleteBtn2').removeClass('hidden');     //show button if no driver is assigned

				        }
				        console.log(name);
				        if(name == calEvent.driver_ack && calEvent.type == "Driver" ){
					        
				        	$('#unAckBtn').removeClass('hidden');     //show button if no driver is assigned
				        	$('#unAckBtn2').removeClass('hidden');     //show button if no driver is assigned

				        }

				        //**THE FOLLOWING CODE HIDES THE UPDATE SECTIONS WHICH IS NOT APPLICABE TO THE CURRENT EVENT STATUS*******************************************
				    				
					
						$('#eventDetails').removeClass('hidden');
						$('#deliveryDetails').removeClass('hidden');
						$('#usageDetails').removeClass('hidden');
						$('#collectionDetails').removeClass('hidden');
						$('#invoiceDetails').removeClass('hidden');

						switch(eventstatus){				//hide options based on eventstatus

							case 'created':
								$('#deliveryDetails').addClass('hidden');
								$('#usageDetails').addClass('hidden');
								$('#collectionDetails').addClass('hidden');
								$('#invoiceDetails').addClass('hidden');	
													
							break;

							case 'acked':
								$('#deliveryDetails').addClass('hidden');
								$('#usageDetails').addClass('hidden');
								$('#collectionDetails').addClass('hidden');		
								$('#invoiceDetails').addClass('hidden');						

							break;

							case 'delivered':
								if (consignment == "Yes") {
									$('#deliveryDetails').addClass('hidden');
									$('#usageDetails').addClass('hidden');
									$('#collectionDetails').addClass('hidden');
									$('#invoiceDetails').addClass('hidden');	

								}else {
									$('#usageDetails').addClass('hidden');
									$('#collectionDetails').addClass('hidden');
									$('#invoiceDetails').addClass('hidden');		
								}					
								
							break;

							case 'used':
								if (consignment == "Yes") {
									$('#deliveryDetails').addClass('hidden');
									$('#collectionDetails').addClass('hidden');
									$('#invoiceDetails').addClass('hidden');	
								}else {
									$('#collectionDetails').addClass('hidden');
									$('#invoiceDetails').addClass('hidden');	
								}	
							break;

							case 'closed':
								if (consignment == "Yes") {
									$('#deliveryDetails').addClass('hidden');
									$('#collectionDetails').addClass('hidden');
								}										
							break;

							
						} 
	   			       	//********END*****************************************
				       

				    },
					dayClick: function(date, allDay, jsEvent, view) {
						
				                $('#calendar').fullCalendar('gotoDate', date);
								 $('#calendar').fullCalendar('changeView', 'agendaDay'); 
							
				      
				    }
				       
				    
				
			   });
	} //end refreshCal()


	function closeModal2()
	{
		 $('#eventDetailsClickModal').modal('hide');
		 $('#eventClickModal').modal('show');
	
	}
    
function convertTimestamp(timestamp,timealso) {
	var d = new Date(timestamp ),	// Convert the passed timestamp to milliseconds
		yyyy = d.getFullYear(),
		mm = ('0' + (d.getMonth() + 1)).slice(-2),	// Months are zero based. Add leading 0.
		dd = ('0' + d.getDate()).slice(-2),			// Add leading 0.
		hh = d.getHours() -2,   //subtract 2 for GMT
		h = hh,
		min = ('0' + d.getMinutes()).slice(-2),		// Add leading 0.
		ampm = 'AM',
		time;
			
	if (hh > 12) {
		h = hh - 12;
		ampm = 'PM';
	} else if (hh === 12) {
		h = 12;
		ampm = 'PM';
	} else if (hh == 0) {
		h = 12;
	}

	// ie: 2013-02-18, 8:35 AM	
	if(timealso == 1)
		time = yyyy + '-' + mm + '-' + dd + ', ' + h + ':' + min + ' ' + ampm;
	else
		time = 	yyyy + '-' + mm + '-' + dd;

	return time;
}

function ackEvent(ackdata){

	$.ajax({   								//ajax call to update driver_ack  DB on acknowledge
      type: "POST",
      url: "../Functions/driverAckEvent.php",   
      data: {eventID:eventid, userID:userid,Ack:ackdata},
      success: function(data) {
    	  var result = $.trim(data);
    	  if(result != "Event acknowledged" &&  result != "Event unacknowledged")
    	  {
    	  	showAlert(data,'danger');
    	  }else
    	  {

    	  		$.ajax({   								//ajax call to insert data into DB on save
			      type: "POST",
			      url: "../Functions/getOriginator.php",
			      data: {Event:eventid},
			      success: function(data) {
			    	 
			    	  var data_rx = JSON.parse(data);
			    	  var message = "";
			    	  var type = "";
			    	 
			    	  if(ackdata == 1)
			    	  {
			    	 	message = "Event Acknowledged - Org:" + data_rx["Name"] ;
			    	 	type = "Event_Acknowledge";
			    	 }else{
			    	 	message = "Event Unacknowledged - Org:" + data_rx["Name"] ;
			    	 	type = "Event_Unacknowledge";
			    	 }
		        	
		        	$.ajax({   								//ajax call to insert data into DB on save
				      type: "POST",
				      url: "../Functions/sendMessageAjax.php",
				      data: {Type:type,Data:message,Originator:data_rx["Id"]},
				      success: function(data) {
	
				      }
				    });
			      }
			    });
    		  showAlert(data,'success');
    	  }
          
          $('#calendar').fullCalendar( 'refetchEvents' );
          $('#eventClickModal').modal('hide');
          $('#eventDetailsClickModal').modal('hide');
          $('#ackBtn').addClass('hidden');
        
      }
    });
}

function editEvent(){

	window.location.href = "../Includes/editEvent.php?id=" + $('#eventClickModal').val();

}

function deleteEvent(){
			
				$.ajax({   								//ajax call to insert data into DB on save
				      type: "POST",
				      url: "../Functions/deleteEvent.php",
				      data: {Id:eventid},
				      success: function(data) {
				        
				        $('html, body').animate({ scrollTop: 0 }, 'fast');  //scroll to top of page
				        if(data == 1)   //if save is successfull
				        {
				        	$('#eventdeleted').show();
				        	$('#eventNotdeleted').hide();				        	
				        	$('html, body').animate({ scrollTop: 0 }, 'fast');
				        	var mytime = setInterval(function(){ $('#eventdeleted').hide();  clearInterval(mytime);}, 4000);

				        }else
				        {
				        	$('#eventNotdeleted').show();
				        	$('#eventdeleted').hide();			        	
				       		var mytime = setInterval(function(){ $('#eventNotdeleted').hide();  clearInterval(mytime); }, 4000);
				        }
				        $('#calendar').fullCalendar( 'refetchEvents' );
				        $('#eventDetailsClickModal').modal('hide');
				        $('#eventClickModal').modal('hide'); 
				      }
				    });			
		}

	function showAlert(data,type){
			$('#Alert').html(data);
			$('#Alert').removeClass().addClass('alert alert-' + type);
			$('#Alert').show();
			var mytime = setInterval(function(){ $('#Alert').hide();  clearInterval(mytime); }, 3000);
		}

	var myApp;
	myApp = myApp || (function () {
	    var pleaseWaitDiv = $('<div class="modal " id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false"><div class="modal-body " \
	    	    style="color:#FFF"><div class=" vertical-center"><h1 style="width:100%" class="text-center">Loading events...</h1>  </div>  </div></div>');
	    return {
	        showPleaseWait: function() {
	            pleaseWaitDiv.modal('show');
	        },
	        hidePleaseWait: function () {
	            pleaseWaitDiv.modal('hide');
	        },

	    };
	})();

	function PrintContent()
	{
	switch(eventstatus){				//hide options based on eventstatus

		case 'created':
		case 'acked':
			var EventDetailsContainer = document.getElementById('eventDetails');
			var WindowObject = window.open("", "PrintWindow",
			"width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
			WindowObject.document.writeln(EventDetailsContainer.innerHTML);
			WindowObject.document.close();
			WindowObject.focus();
			WindowObject.print();
			WindowObject.close();								
		break;

		case 'delivered':
			if (consignment == "Yes") {
				var EventDetailsContainer = document.getElementById('eventDetails');
				var WindowObject = window.open("", "PrintWindow",
				"width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
				WindowObject.document.writeln(EventDetailsContainer.innerHTML);
				WindowObject.document.close();
				WindowObject.focus();
				WindowObject.print();
				WindowObject.close();	
			} else {
				var EventDetailsContainer = document.getElementById('eventDetails');
				var DeliveryDetailsContainer = document.getElementById('deliveryDetails');
				var WindowObject = window.open("", "PrintWindow",
				"width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
				WindowObject.document.writeln(EventDetailsContainer.innerHTML);
				WindowObject.document.writeln(DeliveryDetailsContainer.innerHTML);
				WindowObject.document.close();
				WindowObject.focus();
				WindowObject.print();
				WindowObject.close();	
			}						
		break;

		case 'used':
			if (consignment == "Yes") {		
				var EventDetailsContainer = document.getElementById('eventDetails');
				var UsageDetailsContainer = document.getElementById('usageDetails');
				var WindowObject = window.open("", "PrintWindow",
				"width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
				WindowObject.document.writeln(EventDetailsContainer.innerHTML);
				WindowObject.document.writeln(UsageDetailsContainer.innerHTML);
				WindowObject.document.close();
				WindowObject.focus();
				WindowObject.print();
				WindowObject.close();
			} else {
				var EventDetailsContainer = document.getElementById('eventDetails');
				var DeliveryDetailsContainer = document.getElementById('deliveryDetails');
				var UsageDetailsContainer = document.getElementById('usageDetails');
				var WindowObject = window.open("", "PrintWindow",
				"width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
				WindowObject.document.writeln(EventDetailsContainer.innerHTML);
				WindowObject.document.writeln(DeliveryDetailsContainer.innerHTML);
				WindowObject.document.writeln(UsageDetailsContainer.innerHTML);
				WindowObject.document.close();
				WindowObject.focus();
				WindowObject.print();
				WindowObject.close()
			}								
		break;

		case 'closed':
			if (consignment == "Yes") {	
				var EventDetailsContainer = document.getElementById('eventDetails');
				var UsageDetailsContainer = document.getElementById('usageDetails');
				var InvoiceDetailsContainer = document.getElementById('invoiceDetails');
				var WindowObject = window.open("", "PrintWindow",
				"width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
				WindowObject.document.writeln(EventDetailsContainer.innerHTML);
				WindowObject.document.writeln(UsageDetailsContainer.innerHTML);
				WindowObject.document.writeln(InvoiceDetailsContainer.innerHTML);
				WindowObject.document.close();
				WindowObject.focus();
				WindowObject.print();
				WindowObject.close();
			} else {
				var EventDetailsContainer = document.getElementById('eventDetails');
				var DeliveryDetailsContainer = document.getElementById('deliveryDetails');
				var UsageDetailsContainer = document.getElementById('usageDetails');
				var CollectionDetailsContainer = document.getElementById('collectionDetails');
				var InvoiceDetailsContainer = document.getElementById('invoiceDetails');
				var WindowObject = window.open("", "PrintWindow",
				"width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
				WindowObject.document.writeln(EventDetailsContainer.innerHTML);
				WindowObject.document.writeln(DeliveryDetailsContainer.innerHTML);
				WindowObject.document.writeln(UsageDetailsContainer.innerHTML);
				WindowObject.document.writeln(CollectionDetailsContainer.innerHTML);
				WindowObject.document.writeln(InvoiceDetailsContainer.innerHTML);
				WindowObject.document.close();
				WindowObject.focus();
				WindowObject.print();
				WindowObject.close();
			}								
		break;

	}


}

