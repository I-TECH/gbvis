<?php
//index.php
  $page_title = "Home | GBV";
    $current_page = "home";
	
require_once '../includes/globallevel2.inc.php';
// include "classes/DB.class.php";

 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);

//include "classes/DB.class.php";
include "../includes/headerleve2.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;  font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	  include "../includes/sidebar.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content_with_side_bar">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
		<h3 class="page-title">Analytical Reports</h3>
		   <div class="profile-data" align="left">
        
        
         <?php include "index3.php"; ?>
         
       

</div><br clear="all">
</center>
	    </div> 		
	  </div> 	
 <?php
 include "../includes/footer.php"; 
	}
else
{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../../login.php");
}
?>