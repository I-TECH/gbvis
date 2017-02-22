<?php
//index.php
  $page_title = "Home | GBV";
    $current_page = "home";
	
require_once '../includes/globallevel2.inc.php';


 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);


//include "../includes/headerlevel2.php"; 
include "../includes/Dash_header.php"; 
include "../includes/topbar.php"; //TA:60:1
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;  font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	  include "../includes/sidebarlevel2.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content_with_side_bar">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
		<center><h3 class="page-title">Import</h3></center>
	       
		   <div class="profile-data" align="left">
		    <div>
		     <a class="link-btn" href="file_upload.php">Excel Import</a>
          
            <hr size="1" color="#CCCCCC">
                  </div>
                 <div>
                  <center><h4 class="page-title">Below are the Formats for the Documents to import</h4></center>
                 <br clear="all">
                  <section><a href="../Documents/health_aggregates_database_format _demo.xlsx" download="health_aggregates_database_format _demo.xlsx">CLICK HERE  </a>To download the Excel format template for  health aggregates</section>
                   <!--<section><a href="files/aggregates.xls" download="aggregates.xls">Excel format Template for  Aggregates upload </a></section>-->
                 
                  <section><strong>Make sure your rename the file. Naming Conventions of the file is a Below</strong></p>
                  <p>Example :<u>Health Aggregates January 2015</u> or <u>Health Aggregates January to March 2015</u></p>
                  </section>
                  
                  </div>
                  </div>
                 
                  
                  <br clear="all">

	    </div> 		
	  </div> 	
 <?php
 include "../includes/footer.php"; 
	}
else
{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../login.php");
}
?>