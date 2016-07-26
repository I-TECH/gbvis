<?php
//welcome.php

  $page_title = "welcome  | GBV";
    $current_page = "welcome";

require_once 'includes/global.inc.php';

//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
	header("Location: login.php");
}

//get the user object from the session
$user = unserialize($_SESSION['user']);

include "includes/Dash_header.php"; //TA:60:1
?>
 
	  <div id="main-content">
	    
        <div id="content-body">
       
        
		<!-- TA:60:1 --> 
		<!--<center><h2 class="page-title">Home</h2></center>-->
	<br>Hallo, <?php echo $user->username; ?>. You've been registered and logged in. Welcome! &nbsp;&nbsp;<a href="logout.php">Log Out</a> &nbsp;&nbsp;| &nbsp;&nbsp;<a href="index.php">Go to Homepage</a>

	
	</div> 		
	  </div> 
	
 <?php
 //TA:60:1 -->
include "includes/footer.php";
	

?>