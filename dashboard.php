<?php
//index.php
  $page_title = "Home | GBV";
    $current_page = "Home";
	
require_once 'includes/global.inc.php';


 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);


include "includes/header.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;  font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	  include "includes/sidebar.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
		<center><h3 class="page-title">Welcome to GBVIS</h3></center>
	       <hr size="1" color="#CCCCCC">
		   <div class="profile-data" align="left">
		   
		   <center>
            <div style="float:left; display:block; width:100%;">
			
				<div style="float:left; width:43%; height:500px; border:1px solid #CCCCCC; border-radius:5px; margin-right:10px;" >
				<h2>Main features</h2>
				<div class="mainfeature">
				<div align="left" style="float:left; width 100%; margin-left:25px;">
				<section  style="float:left; width: 50%;" class="IndexDashBoard"><a href="" style="text-decoration:none; margin-left:25px"><p><img src="images/analytical.png" alt="Indicators" height="50" width="45"><h4>Indicators</h4> Each sector has its own indicators</p></a></section>
                               <section  style="float:left; width: 50%;" class=""><a href="" style="text-decoration:none; margin-left:25px"><p><img src="images/aggregates.png" alt="Indicators" height="50" width="45"><h4>Aggregates</h4>All statistical aggragates of all indicators </p></a></section>
                                </div>
                                <div align="left" style="float:left; width 100%; margin-left:25px;">
                               <section  style="float:left; width: 50%;" class=""><a href="" style="text-decoration:none; margin-left:25px"><p><img src="images/importFile.jpeg" alt="Indicators" height="50" width="45"><h4>Import system</h4>After every import an email will be sent to the system administrator who will approve data import, only then will the data be inserted into the current database</p></a></section>
                               <section  style="float:left; width: 50%;" class=""><a href="" style="text-decoration:none; margin-left:25px"><p><img src="images/analytical.jpeg" alt="Indicators" height="50" width="45"><h4>Reports</h4>The system is build in with an easy to use reporting system with graphicaland analysis output </p></a></section>
                               
                                </div>
				</div>
				</div>
				<div style="float:left; width:30%; height:500px; border:1px solid #CCCCCC; border-radius:5px; margin-right:10px;" >
				<h3>Summary</h3>
				<?php
				
				include "Reports/Highcharts/summary_columnChart.htm";
				
				?>
				</div>
				<div style="float:left; width:24%; height:500px; border:1px solid #CCCCCC; border-radius:5px;" >
				<h3>Latest/News</h3>
				</div>
	             
				</div>    
        </center>
		   
		   
      <br clear="all">

</div><br clear="all">
</center>
	    </div> 		
	  </div> 	
 <?php
 include "includes/footer.php"; 
	}
else
{
	//Redirect user back to login page if there is no valid session created
	header("Location: login.php");
}
?>