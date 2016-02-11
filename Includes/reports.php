
<?php
	require_once '../Core/init.php';

	$user = new user(null,$_log);
	$_db = db::getInstance();

	if(!$user->isLoggedIn()) {
		redirect::to('../index.php');
	}

	if(!$user->hasPermission("Manager") )
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
	<?php require_once 'slideMenu.php' 

	?> 
	
	
		

</head> 
<body class="noprint">
	<div class="container-fluid">
	<h4><br/>Please select report type by clicking on tab below.<br/><br/></h4>
		<ul class="nav nav-tabs">
		  <li id="timelinetab" role="presentation"><a onclick="showTimeline()">Timeline</a></li>
		  <li id="statustab" role="presentation"><a onclick="showStatus()">Status</a></li>
		  <li id="usagestab" role="presentation"><a onclick="showUsages()">Usages</a></li>
		  <li id="customerstab" role="presentation"><a onclick="showCustomers()">Customers</a></li>
		  <li id="hospitalstab" role="presentation"><a onclick="showHospitals()">Hospitals</a></li>
		  <li id="repstab" role="presentation"><a onclick="showReps()">Reps</a></li>
		  <li id="driverstab" role="presentation"><a onclick="showDrivers()">Drivers</a></li>
		  <li id="reportstab" role="presentation"><a onclick="Report('None','none')">Reports</a></li>
		</ul>
			<br/>
			<strong>Date Range:  </strong><input id="startDate" class="myInputs date-picker text-center " style="width:110;" >
			<strong> to </strong><input id="endDate" class="myInputs date-picker text-center " style="width:110;" ><br/>
	</div>

	<div class="container-fluid">
		<!-- <div class="row">
			<div class = "well text-center col-xs-12  col-sm-8 col-sm-offset-2" style="background-color:#00A7E1;">

				<button class="btn btn-default col-xs-6 col-sm-2 col-md-offset-1" onclick="showTimeline()" >Timeline</button>
				<button class="btn btn-default col-xs-6 col-sm-2" onclick="showStatus()">Status</button>
				<button class="btn btn-default col-xs-6 col-sm-2" onclick="showUsages()">Usages</button>			
				<button class="btn btn-default col-xs-6 col-sm-2" onclick="showCustomers()">Customers</button>
				<button class="btn btn-default col-xs-6 col-sm-2" onclick="showHospitals()">Hospitals</button>
				<button class="btn btn-default col-xs-6 col-sm-2 col-md-offset-1" onclick="showReps()">Reps</button>
				<button class="btn btn-default col-xs-6 col-sm-2 " onclick="showDrivers()">Drivers</button>
				<button class="btn btn-default col-xs-6 col-sm-2 " onclick="Report('None','none')">Report</button>
				</br>
				<div class=" well col-xs-12 col-sm-10 col-sm-offset-1 col-lg-4 col-lg-offset-4" style="margin-top:5; margin-bottom:0; background-color:#FFF">
					<span class="col-xs-6  " ><strong>Start Date</strong><input id="startDate" class="myInputs date-picker text-center " style="width:110;" ></span >
					<span class="col-xs-6 "><strong>End Date</strong><input id="endDate" class="myInputs date-picker text-center " style="width:110;" ></span >
				</div>
				
			</div>

		</div> -->
		<div class="row" id="graphRow">
			<div class=" col-xs-12 printthis">
				<canvas id="myChart"  ></canvas>				
			</div>
			</br>
			<div class=" col-xs-12">
				<button class="btn btn-success" onclick="window.print()">Print</button>
			</div>
		</div>
		<div class="row" id="reportRow">
		</br>
			<div class="table-responsive col-xs-8 ">
					<table class="table table-hover table-condensed table-bordered display nowrap " id="report_table">
						<thead id="reportTableHead">
							<!--<tr>
							<th>Organiser</th>
							<th>Driver Ack</th>
							<th>Hospital</th>
							<th>Doctor</th>
							<th>Operation_Date</th>
							<th>Equipment</th>
							<th>Rep Attend</th>
							<th>Status</th>
							<th>Event_Logged</th>
							<th>Delivered By</th>
							<th>Delivered Time</th>
							<th>Delivery Logged</th>
							<th>Collected By</th>
							<th>Collected Time</th>
							<th>Used?</th>
							<th>Collection Logged</th>
							</tr>-->
						</thead>
						<tbody id="reportTableBody">
						</tbody> 
					</table>
			</div>
			</br>
			<!--<div class=" col-xs-12">
				<button class="btn btn-success" onclick="saveContent('#report_table')">Print</button>
			</div>
			-->

			
		</div><!--row div-->

		

		
			
	</div>  <!--container div-->
	

<script type="text/javascript">
//set date pickers time picker 
var table1;
	$(document).ready(function() {

	     	var today = new Date();
		    var dd = today.getDate();
		    var lastweek = today.getDate()-7;
		    var mm = today.getMonth()+1; //January is 0!

		    var yyyy = today.getFullYear();

		    if(dd<10){
		        dd='0'+dd
		    } 
		    if(mm<10){
		        mm='0'+mm
		    } 
		    var today = yyyy +'-'+ mm + '-' + dd;			

		    var lastweek = yyyy +'-'+ mm + '-' + lastweek;

	     	$('#startDate').val(lastweek);
			$('#endDate').val(today);



			var date = new Date();
			date.setDate(date.getDate());
			//alert(date);

			$('.date-picker').datepicker({    //using JQUERY UI datepicker not bootstrap
				dateFormat: 'yy-mm-dd',
			    

			});


		 //    $(".date-picker").datepicker({
		 //    		dateFormat: 'yy-mm-dd',
		 //    		startDate : today,
		    		
			// } );
			$(".date-picker").on("change", function () {
			    var id = $(this).attr("id");
			    var val = $("label[for='" + id + "']").text();
			    $("#msg").text(val + " changed");

			    if($('#reportRow').is(":visible")) { 
			    	Report(chartType,Filter);

			    }else if(chartType == 'Time'){
			    	showTimeline();
			    }else if(chartType == 'Status'){
			    	showStatus();
				}else if(chartType == 'Usage'){
			    	showUsages();
				}else if(chartType == 'Doctor'){
			    	showCustomers();
				}else if(chartType == 'Hospital'){
			    	showHospitals();
				}else if(chartType == 'Rep'){
			    	showReps();
				}else if(chartType == 'Driver'){
			    	showDrivers();
				}
			});

			//This code sets default delivery date to current date 
			startDate.onblur = function() {
				if (startDate.value == "") {
					startDate.value = today;

				}			
			};
			//END  of default delivery date

			//This code sets default operation date to current date 
			endDate.onblur = function() {
				if (endDate.value == "") {
					endDate.value = today;

				}			
			};
		

			$('#reportRow').hide();
			


			
			
			
			//plotData("Time" , "line");
			showTimeline();



	});
	var chartType = "None";
	var myLineChart;
	var myBarChart;
	var Filter;

	// Get context with jQuery - using jQuery's .get() method.
	var ctx = $("#myChart").get(0).getContext("2d");
	// This will get the first returned node in the jQuery collection.


	function showTimeline(){
		$('#timelinetab').addClass('active');
		$('#statustab').removeClass('active');
		$('#usagestab').removeClass('active');
		$('#customerstab').removeClass('active');
		$('#hospitalstab').removeClass('active');
		$('#repstab').removeClass('active');
		$('#driverstab').removeClass('active');
		$('#reportstab').removeClass('active');
		try{
			if(myLineChart)
				myLineChart.destroy();
			if(myBarChart)
				myBarChart.destroy();
		}finally{}
		$('#graphRow').show();
		$('#reportRow').hide();
		chartType = 'Time';
		plotData("Time" , "line");

	}
	function showStatus(){
		$('#timelinetab').removeClass('active');
		$('#statustab').addClass('active');
		$('#usagestab').removeClass('active');
		$('#customerstab').removeClass('active');
		$('#hospitalstab').removeClass('active');
		$('#repstab').removeClass('active');
		$('#driverstab').removeClass('active');
		$('#reportstab').removeClass('active');
		try{
			if(myLineChart)
				myLineChart.destroy();
			if(myBarChart)
				myBarChart.destroy();
		}finally{}

		$('#graphRow').show();
		$('#reportRow').hide();
		chartType = 'Status';
		plotData("Status" , "bar");

	}


	function showUsages(){
		$('#timelinetab').removeClass('active');
		$('#statustab').removeClass('active');
		$('#usagestab').addClass('active');
		$('#customerstab').removeClass('active');
		$('#hospitalstab').removeClass('active');
		$('#repstab').removeClass('active');
		$('#driverstab').removeClass('active');
		$('#reportstab').removeClass('active');
		try{
			if(myLineChart)
				myLineChart.destroy();
			if(myBarChart)
				myBarChart.destroy();
		}finally{}
		$('#graphRow').show();
		$('#reportRow').hide();
		chartType = 'Usage';
		plotData("Usage" , "bar");


		
	}


	function showCustomers(){
		$('#timelinetab').removeClass('active');
		$('#statustab').removeClass('active');
		$('#usagestab').removeClass('active');
		$('#customerstab').addClass('active');
		$('#hospitalstab').removeClass('active');
		$('#repstab').removeClass('active');
		$('#driverstab').removeClass('active');
		$('#reportstab').removeClass('active');
		try{
			if(myLineChart)
				myLineChart.destroy();
			if(myBarChart)
				myBarChart.destroy();
		}finally{}
		$('#graphRow').show();

		$('#reportRow').hide();
		chartType = 'Doctor';
		plotData("Doctor" , "bar");


	}
	function showHospitals(){
		$('#timelinetab').removeClass('active');
		$('#statustab').removeClass('active');
		$('#usagestab').removeClass('active');
		$('#customerstab').removeClass('active');
		$('#hospitalstab').addClass('active');
		$('#repstab').removeClass('active');
		$('#driverstab').removeClass('active');
		$('#reportstab').removeClass('active');
		try{
			if(myLineChart)
				myLineChart.destroy();
			if(myBarChart)
				myBarChart.destroy();
		}finally{}
		$('#graphRow').show();

		$('#reportRow').hide();
		chartType = 'Hospital';
		plotData("Hospital" , "bar");


	}



	function showReps(){
		$('#timelinetab').removeClass('active');
		$('#statustab').removeClass('active');
		$('#usagestab').removeClass('active');
		$('#customerstab').removeClass('active');
		$('#hospitalstab').removeClass('active');
		$('#repstab').addClass('active');
		$('#driverstab').removeClass('active');
		$('#reportstab').removeClass('active');
		try{
			if(myLineChart)
				myLineChart.destroy();
			if(myBarChart)
				myBarChart.destroy();
		}finally{}
		$('#graphRow').show();
		$('#reportRow').hide();
		chartType = 'Rep';
		plotData("Rep" , "bar");




	}

	function showDrivers(){
		$('#timelinetab').removeClass('active');
		$('#statustab').removeClass('active');
		$('#usagestab').removeClass('active');
		$('#customerstab').removeClass('active');
		$('#hospitalstab').removeClass('active');
		$('#repstab').removeClass('active');
		$('#driverstab').addClass('active');
		$('#reportstab').removeClass('active');
		try{
			if(myLineChart)
				myLineChart.destroy();
			if(myBarChart)
				myBarChart.destroy();
		}finally{}
		$('#graphRow').show();
		$('#reportRow').hide();
		chartType = 'Driver';
		plotData("Driver" , "bar");




	}

	function Report(chart,filter){   //chart = which graph e.g. Usages   filter = filter value eg. Doctor = M Minny
		$('#timelinetab').removeClass('active');
		$('#statustab').removeClass('active');
		$('#usagestab').removeClass('active');
		$('#customerstab').removeClass('active');
		$('#hospitalstab').removeClass('active');
		$('#repstab').removeClass('active');
		$('#driverstab').removeClass('active');
		$('#reportstab').addClass('active');
		Filter = filter;
		try{
			if(myLineChart)
				myLineChart.destroy();
			if(myBarChart)
				myBarChart.destroy();
		}finally{}
		
		showReport("Report1",filter,chart);
		$('#graphRow').hide();

		$('#reportRow').show();




	}
	function showReport(types,filter,chart){	//chart = which graph e.g. Usages   filter = filter value eg. Doctor = M Minny

     // var newRow = document.getElementById('reportTableBody');

      //newRow.innerHTML = "";	 
     // var newHead = document.getElementById('reportTableHead');
     // newHead.innerHTML = "";	
    //clearReportTable();
	

		$.ajax({   								//ajax call to insert data into DB on save
      type: "POST",     
      url: "../Functions/getReportData.php",
      data: {Type:types,Filter:filter,Chart:chart,Start:$('#startDate').val(),End:$('#endDate').val()},
      success: function(data) {
      //	console.log(data);
        var data_rx = JSON.parse(data);
       //console.log(data_rx);
       $('#reportTableHead').empty();
		$('#reportTableBody').empty();
		

         populateReportTableHead(data_rx[0]);
 //console.log(data_rx.length + "  " + data_rx['0']["Organiser"]);
        for(var i = 0;i < data_rx.length; i++){

        	if(types == "Report1"){
        		

        		populateReportTable(data_rx[i]);


        	}
        }
      
      	if(!$('#report_table').hasClass('dataTable')){
      		setReportTable();
      	}  
        




       
       

     	}  
     	
	});
		

}



function populateReportTableHead(data){
	var newHead = document.getElementById('reportTableHead');
	      var newHtml = '<tr>';
			for (key in data) {
			        newHtml += '<th>' + key + '</th>';
			    }
		    



	   	  newHtml += '</tr>';
	      newHead.innerHTML = newHtml;	      

	      return;  


}
 function populateReportTable(data){

     // console.log(data.length + "  " + data[0]);



	
	 var newRow = document.getElementById('reportTableBody');

	      var newHtml = '<tr>';

	       for (key in data) {
	       	if(data[key] == null) {data[key] = "N/A"}

	        newHtml += '<td>' + data[key]  + '</td>';
	    }
	    newHtml += '</tr>';
	   	 
	      newRow.innerHTML += newHtml;	  


	         return; 

}


function clearReportTable(){	       

	var table1 = new $('#report_table').DataTable();
	// table1.destroy();
	 table1.fnClearTable();
	//table1.column(3).visible(false); //hide doctor name col
	

	
	return; 
}

function setReportTable(){	       

	 table1 = new $('#report_table').DataTable({
		        "dom": 'T<"clear">lfrtip',
		        "tableTools": {
		            "sSwfPath": "../Scripts/copy_csv_xls_pdf.swf",
		            "aButtons": [
		                "copy",
		        		 "xls", {
			                    "sExtends": "pdf",
			                    "sPdfOrientation": "landscape",
			                    "sPdfSize": "A3"
			                    
			                } ]
		                
		            
		        }
		    } );



	
	//table1.column(3).visible(false); //hide doctor name col
	

	$('#report_table tbody').on( 'click', 'tr', function () {	        	          
	    selectedRow = $(this);	       
	    selectedRTU = selectedRow[0].children[0].innerHTML;
	   //	console.log(selectedRTU);  
	  // 	$('#main1').hide();
	   //	$('#main2').show();		
	  
	});

	return; 
}




	function plotData(types, type){

		$.ajax({   								//ajax call to insert data into DB on save
      type: "POST",
      url: "../Functions/getReportData.php",
      data: {Type:types,Start:$('#startDate').val(),End:$('#endDate').val()},
      success: function(data) {
      	//console.log(data);
        var data_rx = JSON.parse(data);
        var labelsarray = [];
        var countarray = [];

        for(var i = 0;i < data_rx.length; i++){

        	if(types == "Time"){
        		labelsarray[i] = data_rx[i]["Date"];
        	}else
        	if(types == "Doctor"){
        		labelsarray[i] = data_rx[i]["Name"];
        	}else
        	if(types == "Rep"){
        		labelsarray[i] = data_rx[i]["Name"];
        	}else
        	if(types == "Driver"){
        		labelsarray[i] = data_rx[i]["Name"];
        	}
        	if(types == "Hospital"){
        		labelsarray[i] = data_rx[i]["Name"];
        	}
        	if(types == "Usage"){
        		labelsarray[i] = data_rx[i]["Name"];
        	}
        	if(types == "Status"){
        		labelsarray[i] = data_rx[i]["Name"];


        	}




        	countarray[i] = parseInt(data_rx[i]["totalCount"]);
        }



       // console.log(data_rx);
       // console.log(countarray);


       var reportdata = {
		    labels: labelsarray,
		    datasets: [
		        {
		            label: "My First dataset",
		            fillColor: "rgba(220,220,220,0.2)",
		            strokeColor: "rgba(220,220,220,1)",
		            pointColor: "rgba(220,220,220,1)",
		            pointStrokeColor: "#fff",
		            pointHighlightFill: "#fff",
		            pointHighlightStroke: "rgba(220,220,220,1)",
		            data: countarray
		        }
		    ]
		};

		// console.log(reportdata);



      


	
	

	Chart.defaults.global = {
		    // Boolean - Whether to animate the chart
		    animation: true,

		    // Number - Number of animation steps
		    animationSteps: 60,

		    // String - Animation easing effect
		    // Possible effects are:
		    // [easeInOutQuart, linear, easeOutBounce, easeInBack, easeInOutQuad,
		    //  easeOutQuart, easeOutQuad, easeInOutBounce, easeOutSine, easeInOutCubic,
		    //  easeInExpo, easeInOutBack, easeInCirc, easeInOutElastic, easeOutBack,
		    //  easeInQuad, easeInOutExpo, easeInQuart, easeOutQuint, easeInOutCirc,
		    //  easeInSine, easeOutExpo, easeOutCirc, easeOutCubic, easeInQuint,
		    //  easeInElastic, easeInOutSine, easeInOutQuint, easeInBounce,
		    //  easeOutElastic, easeInCubic]
		    animationEasing: "easeOutQuart",

		    // Boolean - If we should show the scale at all
		    showScale: true,

		    // Boolean - If we want to override with a hard coded scale
		    scaleOverride: false,

		    // ** Required if scaleOverride is true **
		    // Number - The number of steps in a hard coded scale
		    scaleSteps: null,
		    // Number - The value jump in the hard coded scale
		    scaleStepWidth: null,
		    // Number - The scale starting value
		    scaleStartValue: null,

		    // String - Colour of the scale line
		    scaleLineColor: "rgba(0,0,0,.1)",

		    // Number - Pixel width of the scale line
		    scaleLineWidth: 1,

		    // Boolean - Whether to show labels on the scale
		    scaleShowLabels: true,

		    // Interpolated JS string - can access value
		    scaleLabel: "<%=value%>",

		    // Boolean - Whether the scale should stick to integers, not floats even if drawing space is there
		    scaleIntegersOnly: true,

		    // Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
		    scaleBeginAtZero: false,

		    // String - Scale label font declaration for the scale label
		    scaleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

		    // Number - Scale label font size in pixels
		    scaleFontSize: 12,

		    // String - Scale label font weight style
		    scaleFontStyle: "normal",

		    // String - Scale label font colour
		    scaleFontColor: "#666",

		    // Boolean - whether or not the chart should be responsive and resize when the browser does.
		    responsive: true,

		    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
		    maintainAspectRatio: false,

		    // Boolean - Determines whether to draw tooltips on the canvas or not
		    showTooltips: true,

		    // Function - Determines whether to execute the customTooltips function instead of drawing the built in tooltips (See [Advanced - External Tooltips](#advanced-usage-custom-tooltips))
		    customTooltips: false,

		    // Array - Array of string names to attach tooltip events
		    tooltipEvents: ["mousemove", "touchstart", "touchmove"],

		    // String - Tooltip background colour
		    tooltipFillColor: "rgba(0,0,0,0.8)",

		    // String - Tooltip label font declaration for the scale label
		    tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

		    // Number - Tooltip label font size in pixels
		    tooltipFontSize: 14,

		    // String - Tooltip font weight style
		    tooltipFontStyle: "normal",

		    // String - Tooltip label font colour
		    tooltipFontColor: "#fff",

		    // String - Tooltip title font declaration for the scale label
		    tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

		    // Number - Tooltip title font size in pixels
		    tooltipTitleFontSize: 14,

		    // String - Tooltip title font weight style
		    tooltipTitleFontStyle: "bold",

		    // String - Tooltip title font colour
		    tooltipTitleFontColor: "#fff",

		    // Number - pixel width of padding around tooltip text
		    tooltipYPadding: 6,

		    // Number - pixel width of padding around tooltip text
		    tooltipXPadding: 6,

		    // Number - Size of the caret on the tooltip
		    tooltipCaretSize: 8,

		    // Number - Pixel radius of the tooltip border
		    tooltipCornerRadius: 6,

		    // Number - Pixel offset from point x to tooltip edge
		    tooltipXOffset: 10,

		    // String - Template string for single tooltips
		    tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",

		    // String - Template string for multiple tooltips
		    multiTooltipTemplate: "<%= value %>",

		    // Function - Will fire on animation progression.
		    onAnimationProgress: function(){},

		    // Function - Will fire on animation completion.
		    onAnimationComplete: function(){}
		}

		if(type == "line"){
			var options = {

				    ///Boolean - Whether grid lines are shown across the chart
				    scaleShowGridLines : true,

				    //String - Colour of the grid lines
				    scaleGridLineColor : "rgba(0,0,0,.05)",

				    //Number - Width of the grid lines
				    scaleGridLineWidth : 1,

				    //Boolean - Whether to show horizontal lines (except X axis)
				    scaleShowHorizontalLines: true,

				    //Boolean - Whether to show vertical lines (except Y axis)
				    scaleShowVerticalLines: true,

				    //Boolean - Whether the line is curved between points
				    bezierCurve : true,

				    //Number - Tension of the bezier curve between points
				    bezierCurveTension : 0.4,

				    //Boolean - Whether to show a dot for each point
				    pointDot : true,

				    //Number - Radius of each point dot in pixels
				    pointDotRadius : 4,

				    //Number - Pixel width of point dot stroke
				    pointDotStrokeWidth : 1,

				    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
				    pointHitDetectionRadius : 20,

				    //Boolean - Whether to show a stroke for datasets
				    datasetStroke : true,

				    //Number - Pixel width of dataset stroke
				    datasetStrokeWidth : 2,

				    //Boolean - Whether to fill the dataset with a colour
				    datasetFill : true,

				    //String - A legend template
				    legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

				};


			 myLineChart = new Chart(ctx).Line(reportdata, options);
			 myBarChart = null;
		}else
		if(type == "bar"){
			var options = {

				    
			    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
			    scaleBeginAtZero : true,

			    //Boolean - Whether grid lines are shown across the chart
			    scaleShowGridLines : true,

			    //String - Colour of the grid lines
			    scaleGridLineColor : "rgba(0,0,0,.05)",

			    //Number - Width of the grid lines
			    scaleGridLineWidth : 1,

			    //Boolean - Whether to show horizontal lines (except X axis)
			    scaleShowHorizontalLines: true,

			    //Boolean - Whether to show vertical lines (except Y axis)
			    scaleShowVerticalLines: true,

			    //Boolean - If there is a stroke on each bar
			    barShowStroke : true,

			    //Number - Pixel width of the bar stroke
			    barStrokeWidth : 2,

			    //Number - Spacing between each of the X value sets
			    barValueSpacing : 5,

			    //Number - Spacing between data sets within X values
			    barDatasetSpacing : 1,

			    //String - A legend template
			    legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

			

				};


			 myBarChart = new Chart(ctx).Bar(reportdata, options);
			 myLineChart = null;

		}

		graph = document.getElementById('myChart');

		graph.onclick = function(evt){
		   // var activePoints = myLineChart.getPointsAtEvent(evt);
		    // => activePoints is an array of points on the canvas that are at the same position as the click event.
		    if(myLineChart){
				 var activePoints = myLineChart.getPointsAtEvent(evt);
				// console.log(activePoints[0].label);
				  if(activePoints.length > 0){
			   			Report(chartType,activePoints[0].label);
			   		}
				}
			if(myBarChart){
				var activeBars = myBarChart.getBarsAtEvent(evt);
		   		if(activeBars.length > 0){
		   			Report(chartType,activeBars[0].label);
		   		}
			}
		   
		};
	}
    });

	}
function PrintContent(type)
{
//alert(eventstatus);

	var PrintContainer = document.getElementById('myChart');
	if(type == 2)
	{
		var PrintContainer = document.getElementById('report_table');     //if it is a report change data to report table

		Window.print();
	}
		
		var WindowObject = window.open("", "PrintWindow",
		"width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.document.writeln(PrintContainer.innerHTML);
		WindowObject.document.close();
		WindowObject.focus();
	//	WindowObject.print();
		WindowObject.close();								
	
}

function saveContent(table0){
	//console.log(table0);
	//var table2 = document.getElementById(table0);
 	var doc = new jsPDF();
		// We'll make our own renderer to skip this editor
		var specialElementHandlers = {
			'#editor': function(element, renderer){
				return true;
			}
		};

		// All units are in the set measurement for the document
		// This can be changed to "pt" (points), "mm" (Default), "cm", "in"
		doc.fromHTML($(table0).get(0), 15, 15, {
			'width': 170, 
			'elementHandlers': specialElementHandlers
		});


}

	</script>


	
</body>	
	
</html>
