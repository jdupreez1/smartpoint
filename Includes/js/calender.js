
	var userid;
	var repFeed;
	var driverFeed;
	var driver;
	var eventid;

	function resizeCalendar(calendarView) {
	    if(calendarView.name === 'agendaWeek' || calendarView.name === 'agendaDay') {
	        // if height is too big for these views, then scrollbars will be hidden
	        calendarView.setHeight(9999);
	    }
	}
	function setID(userID) {
	    userid = userID;
	}
	function setRep(active) {
	    repFeed = active;
	}
	function setDriver(active) {
	    driverFeed = active;
	}

	$(document).ready(function() {

		refreshCal();			        
		
	});

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
					eventSources: [
				        // your JSON event source
				        {
				            url: '../Functions/calendarFeedAll.php',
				            cache: false,
				            type: 'GET',
				            data: {
				                userID: userid,
				                active: 1
				            },
				            color: '#99C4E0',    // an option!
				            textColor: 'black'  // an option!
				        }

				        // your ajax event source
				        
				    ],
				    eventClick: function(calEvent, jsEvent, view) {
							       
				       eventid = calEvent.id;             		//get db id for the cicked event
				       eventstatus = calEvent.status;				 
					   consignment = calEvent.consignment;

				       //##THE FOLOWING CODE GETS EVENTS INFORMATION FOR MODAL2.

					    	$.ajax({   								//ajax call to insert data into DB on save
							      type: "POST",
							      url: "../Functions/getEventInfo.php",
							      data: {Page : 'Calender', Eventid: eventid},
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
	      					 		$('#DateInvoicedRow').html(data_rx[0]["Date Invoiced"]);
	      					 		$('#InvoicedLoggedRow').html(data_rx[0]["Invoice Logged"]); 

							      }
							});
					    //##END OF GETS EVENTS INFORMATION

						$('#eventDetailsClickModal').modal('show');


				       if(calEvent.driver_ack != "None"){					//if driver already acked, show name
				       		driver = calEvent.driver_ack; 
				        	$('.modal-body #driverName').html(driver);

					    }else
					    {
							$('.modal-body #driverName').html('None');
							
					    }
				        // change the border color just for fun
				        //$(this).css('border-color', 'red');

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
				        $('#DriverRow').html(calEvent.driver_ack);
				        $('#ConsignmentRow').html(calEvent.consignment);
				        $('#CommentRow').html(calEvent.comments);

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
								if (consignment == "yes") {
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
								if (consignment == "yes") {
									$('#deliveryDetails').addClass('hidden');
									$('#collectionDetails').addClass('hidden');
									$('#invoiceDetails').addClass('hidden');
								}else {
									$('#collectionDetails').addClass('hidden');
									$('#invoiceDetails').addClass('hidden');	
								}	
							break;

							case 'closed':
								if (consignment == "yes") {
									$('#deliveryDetails').addClass('hidden');
									$('#collectionDetails').addClass('hidden');
									$('#invoiceDetails').addClass('hidden');
								} else {
									$('#invoiceDetails').addClass('hidden');
								}	
							break;
						} 
	   			       	//********END*****************************************
				        
				    }       
			   });
			} //end refreshCal()



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
