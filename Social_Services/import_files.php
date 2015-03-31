<?php
//index.php
  $page_title = "Home | GBV";
    $current_page = "home";
	
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
		<center><h3 class="page-title">Import</h3></center>
	       
		   <div class="profile-data" align="left">
		    <div>
		     <a class="link-btn" href="Upload_excel/file_upload.php">Excel Import</a>
          
            <hr size="1" color="#CCCCCC">
                  </div>
                 <div>
                  <center><h4 class="page-title">Below are the Formats for the Documents to import</h4></center>
                   
                   <section><a href="files/Indicators.xls" download="indicators.xls">Excel format Template for Indicators upload </a></section>
                   <!--<section><a href="files/aggregates.xls" download="aggregates.xls">Excel format Template for  Aggregates upload </a></section>-->
                   <br clear="all">
                 
                  
                  </div>
                  </div>
                 
                  
                  <br clear="all">

	    </div> 		
	  </div> 	
 <?php
 include "includes/footer.php"; 
	}
else
{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../login.php");
}
?>