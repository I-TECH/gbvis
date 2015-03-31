<?php
//welcome.php
  $page_title = "User Profile | GBV";
    $current_page = "User Profile";
	
require_once 'includes/global.inc.php';

//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
	header("Location: login.php");
}

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
		<center><h3 class="page-title">Home</h3></center>
		<div class="profile-data" align="left">
	Hey there, <?php echo $user->username; ?>. You've been registered and logged in. Welcome! <a href="logout.php">Log Out</a> | <a href="index.php">Return to Homepage</a>

	
	
	
	</div> 	
	</div> 	
	  </div> 
	   </div> 
 <?php
 include "includes/footer.php"; 
	

?>