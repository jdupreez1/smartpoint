
<?php
	
	require_once '../Core/init.php';
	
	
	
	$dbh = null;
	
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
	<title>Vectrack Tracking</title>
	<?php require_once 'add_headinfo.php' ?> <!-- this adds css, javascript, bootstrap  -->
	<script>
      $(function() {
        
        $( "#accordion" ).accordion({
            active: false,
            collapsible: true,
            event: "click ",
            heightStyle: "content"
            });

       
      });
  </script>

</head> 
		
<body>

	

	<?php require_once 'add_navbar.php' ?> <!-- this adds navbar -->
	


<div class="container col-xs-12">
	<div class="row">
                         
                          
      
     <div class="well col-xs-12 ">
     	
     <p class = "red_note">
     Choose a RTU from the list and then use the drawing
     toolbar on the left-hand side of the map to draw the desired GeoFence. <br/>
     Remember to save the GeoFence when you are satisfied with it.
     </p>



     	<div id="accordion" class="col-xs-12 col-md-6" >
          <h3 id="SelRTUDescr" >Choose RTU</h3>
           <div >
	          <div>    
	               <span>
	                   <table class = "table" id="rtu_table">
	                        <thead>
	                            <tr>
	                                <th>Id</th>
	                                <th>Description</th>
	                                
	                            </tr>
	                        </thead>
	                        
	                        <tbody id="rtuTableBody">
	                           
	                       
	                         </tbody> 
	                       
	                       
	                   </table>
	                    </span>
	           </div>
         	</div>
      
                  
     	</div> <!-- accordion 1 div -->
     	<button class="btn btn-success" onclick="saveFence()">Save</button>
     	<!--<span class = "col-xs-12">
     	<label class="checkbox-inline"><input id="chkMon" type="checkbox" value="">Mon</label>
		<label class="checkbox-inline"><input id="chkTue" type="checkbox" value="">Tue</label>
		<label class="checkbox-inline"><input id="chkWed" type="checkbox" value="">Wed</label>
		<label class="checkbox-inline"><input id="chkThu" type="checkbox" value="">Thu</label>
		<label class="checkbox-inline"><input id="chkFri" type="checkbox" value="">Fri</label>
		<label class="checkbox-inline"><input id="chkSat" type="checkbox" value="">Sat</label>
		<label class="checkbox-inline"><input id="chkSun" type="checkbox" value="">Sun</label>

     	</span>
     	-->

     </div> <!--well div-->
                          
                   	
	       
	    
	</div>   <!--Row div-->


	<div class="row">
	<div id="noRTUAlert" class="alert alert-danger" role="alert">You have not selected a RTU</div>
	<div id="dataSaved" class="alert alert-success" role="alert">GeoFence was successfully saved</div>
	<div id="dataNOTSaved" class="alert alert-danger" role="alert">GeoFence was not saved</div>
	<div id="dataNOTSavedLimit" class="alert alert-danger" role="alert">GeoFence was not saved - You exceeded the 100 point limit</div>
		<div id="map" class="col-xs-12" >
			
		</div>
	</div> <!--Row div-->
</div>

<script>
	$('#dataNOTSaved').hide();
	$('#dataSaved').hide();
	$('#dataNOTSavedLimit').hide();

		var geoObj = {};
		var selectedRTU;
		var shapes;
		var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
			osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
			osm = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib}),
			map = new L.Map('map', {layers: [osm], center: new L.LatLng(-25.827118, 28.243561), zoom: 10 });

		var drawnItems = new L.FeatureGroup();
		map.addLayer(drawnItems);
		var drawControl = new L.Control.Draw({
			draw:{
				position: 'topleft',
				polyline:false,
				rectangle:false,					//disable all other shapes
				marker:false,
				polygon: {
					title: 'Draw a polygon!',
					allowIntersection: false,		//do not allow intersect of lines
					drawError: {
						color: '#b00b00',			//polygon colour when intersecting error
						timeout: 2000
					},
					shapeOptions: {
						color: '#0066ff'			//polygon colour
					},
					showArea: true					//show estimated area covered by polygon
					

				},
				
				circle: {
					shapeOptions: {
						color: '#662d91'			//circle colour
					}
				}
			},
			edit: {
				featureGroup: drawnItems,			// layer which is editable / removalbe
				edit:false             			//disable edit option in toolbar
			},
			

		});
		controlExist = false;   //place keeper to indicate whether the control has been added to the map
		

		map.on('draw:created', function (e) {
			var type = e.layerType,
			layer = e.layer;
			drawnItems.clearLayers();			//delete other drawn items and keep latest
			
			drawnItems.addLayer(layer);
			

			shapes = getShapes(type,layer);		//get the coordinates,type,radius



		});

		   
function getShapes(type,layer){

	var shape;	
	var shape_for_db = [];
	
	var shape = layer.toGeoJSON();
		
	if (type === 'polygon') {

		
		geoObj["type"] = 1;								//type = 1 for polygon		
		geoObj["radius"] = 0;								//radius is 0 for polygon
		geoObj["coordinates"] = shape['geometry']['coordinates'][0];
	}else
	if (type === 'circle') {

		geoObj["type"] = 0;  								//type = 0 for circle
		geoObj["radius"]  = layer.getRadius();		                         		
		geoObj["coordinates"] = shape['geometry']['coordinates'];
		
	}

	
	
	

	return ;
}

$(function(){

    $(".dropdown-menu li a").click(function(){
     document.getElementById("rtu_choose").innerHTML = '';
      $("#rtu_choose").text($(this).text() + ' ');
      $("#rtu_choose").val($(this).text());
      document.getElementById("rtu_choose").innerHTML += '<span class="caret"> </span>';

   });

});





    function populateRTUTable(RTU_data,RTU_data2){


	 var newRTU = document.getElementById('rtuTableBody');
       // newRTU.innerHTML = '';
        var newHtml;
       
            
              newHtml = '<tr><td>' + RTU_data  +'</td><td>' + RTU_data2  +'</td></tr>';
              
             newRTU.innerHTML += newHtml;
          
 			//setRTUtable();
	}


       function setRTUtable(){
        
        var table = new $('#rtu_table').DataTable();
     
        $('#rtu_table tbody').on( 'click', 'tr', function () {
        
			$('#noRTUAlert').hide();     //hide the alert for not RTU
		
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#noRTUAlert').show();				 //show the alert for not RTU
                hideDrawControl();
                 document.getElementById('SelRTUDescr').innerHTML = '<strong>RTU: None</strong>';
                 drawnItems.clearLayers();
            }
            else 
            {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                selectedRow = $(this);
                drawnItems.clearLayers();
                showDrawControl();
                document.getElementById('SelRTUDescr').innerHTML = '<strong>RTU: ' + selectedRow[0].children[1].innerHTML + '</strong>';
                selectedRTU = selectedRow[0].children[0].innerHTML;

		        

		        getRTUFence(selectedRTU);
			      
			    $( "#accordion" ).accordion({active: false });            
			 }

			 
        } );
     
        
        
    }

    function saveFence(){
    	//console.log(geoObj['coordinates']);
		//console.log(geoObj['radius']);
		//console.log(geoObj['type']);
		//console.log(selectedRTU);
		
		if(Object.keys(geoObj['coordinates']).length <= 100)   //check that fewer than 100 points were chosen
		{
		 $.ajax({   								//ajax call to insert data into DB on save
		      type: "POST",
		      url: "../Functions/saveGeoFence.php",
		      data: {coordinates:geoObj['coordinates'],radius:geoObj['radius'],type:geoObj['type'],rtuID:selectedRTU},
		      success: function(data) {
		        
		        if(data == 1)   //if save is successfull
		        {
		        	$('#dataSaved').show();
		        	$('#dataNOTSaved').hide();
		        	var mytime = setInterval(function(){ $('#dataSaved').hide();  clearInterval(mytime);}, 4000);
		        	

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


    function getRTUFence(RTU_Id) {

    	$.ajax({   								//ajax call to get data into DB on save
		      type: "POST",
		      url: "../Functions/getGeoFence.php",
		      data: {rtuID:RTU_Id},
		      success: function(data) {
		        var plotdata = [] ;
		        if(data != 0)   //if get is successfull
		        {
		        	//console.log(data);
		        	var data_rx = JSON.parse(data);
		        	console.log(data_rx['Fence_Type']);
		        	if(data_rx['Fence_Type'] == 1)
		        	{
			        	for(i = 0;i<99; i++)
			        	{
			        		if(parseFloat(data_rx['Coord_'+i+'_Long']) != 0)
			        		plotdata.push([parseFloat(data_rx['Coord_'+i+'_Long']),parseFloat(data_rx['Coord_'+i+'_Lat'])]);
			        		 
			        	}
			        	
						//console.log(plotdata);
						  // Define polyline options
						  // http://leafletjs.com/reference.html#polyline
						  var polyline_options = {
						      color: '#FF6600'
						  };

						
						  // http://leafletjs.com/reference.html#polygon
						  // create a red polyline from an array of LatLng points
								var polygon = L.polygon(plotdata, {color: 'red'}).addTo(drawnItems);

						 // zoom the map to the polyline
							map.fitBounds(polygon.getBounds());
					 
					}else    //is a circle
					{
						plotdata.push(parseFloat(data_rx['Coord_0_Long']),parseFloat(data_rx['Coord_0_Lat']));
						// Define circle options
						  // http://leafletjs.com/reference.html#circle
							var circle_options = {
						      color: '#FF6600',      // Stroke color
						      opacity: 1,         // Stroke opacity
						      weight: 3,         // Stroke weight
						      fillColor: '#FF6600',  // Fill color
						      fillOpacity: 0.6    // Fill opacity
						  };
						//  console.log(plotdata);
						  var circle = L.circle(plotdata, parseFloat(data_rx['Radius']), circle_options).addTo(drawnItems);
						  
						  map.on('draw:edited', function(e) {
						     
							var	layer = e.layer;
								drawnItems.clearLayers()			//delete other drawn items and keep latest
								
								drawnItems.addLayer(layer);
						  });

						  map.fitBounds(circle.getBounds());

					}
  
		        	//console.log(plotdata);

		        }else
		        {
		        	console.log("No data returned: " + data);
		        } 
		      }
		    });


    }

    function hideDrawControl(){

    
    	drawControl.removeFrom(map);
    	controlExist = false;

    
    }

    function showDrawControl(){
    	
    	if(controlExist)
    	drawControl.removeFrom(map);
		
		map.addControl(drawControl);
		controlExist = true;
    }

	</script>

	<?php    //populate table with RTUs
	//var_dump($user->data()->Company_Id);

			if($dbh = $_db->get('Units', array('Company_Id','=',$user->data()->Company_Id))){
				if($dbh->counts() > 0){
					foreach($dbh->results() as $key)
					{
						
						echo "<script type='text/javascript'> populateRTUTable($key->Unit_Id,'$key->Unit_Description'); </script>";
					}

				echo "<script type='text/javascript'> setRTUtable(); </script>";
 
					
				}else
				{
					echo "Nothing found in DB";
				}

			}
			else {
				echo "Could not read from DB";
			}
	?>
</body>	
	
</html>