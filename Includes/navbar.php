

	  <nav class="navbar navbar-default navbar-inverse" role="navigation">
    	<div class="container-fluid">
	      
	        <div class="navbar-brand"><a href="home.php">Booking</a></div>
	      
	     
 	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      
      <!-- I don't want it apart of the collapsible portion -->
    <div class="collapse navbar-collapse ">
        <ul id = "nav_list" class="nav navbar-nav">
         		<li><a href="home.php">Home</a></li>
		         <li  class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" >Settings <span class="caret"></span></a>
		          <ul class="dropdown-menu">
		            <li><a href="update.php">Profile</a></li>
		            <li><a href="changepassword.php">Password</a></li>
		            <li><a href="fences.php">Geo Fences</a></li>
		            <li><a href="notifications.php">Notifications</a></li>
		            <li><a href="rtuprofiles.php">RTU Profiles</a></li>
		          </ul>
		         </li>
       
        	 <?php //check whether user has admin rights
				 if($user->hasPermission('Admin')){ ?>
				 <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" >Admin<span class="caret"></span></a>
		          <ul class="dropdown-menu">
		          	<li><a href="company.php">Companies</a></li>
          			<li><a href="user.php">Users</a></li>
		            <li><a href="rtu.php">RTUs</a></li>
		            <li><a href="logpage.php">Log</a></li>
		          </ul>
				 <?php } ?>		          
		        </li>
		        <li><a href="downloads.php">Downloads</a></li>
		        <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>


	<script type="text/javascript">
	$('[data-toggle=dropdown]').each(function() {
	    this.addEventListener('click', function() {}, false);
	});
	</script>
