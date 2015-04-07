<?php 

  $page_title = "Reset Password | GBV";
    $current_page = "Reset password";
	
	
require_once 'includes/global.inc.php';

//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
	header("Location: login.php");
}

//get the user object from the session
$user = unserialize($_SESSION['user']);

//initialize php variables used in the form
$firstname = $user->firstname;
$lastname = $user->lastname;
$username = $user->username;
$email = $user->email;
$sector = $user->sector;
$user_group = $user->user_group;
$mobile_phone = $user->mobile_phone;
$message = "";

//check to see that the form has been submitted

       $groups_result = $db->selectData("user_groups","id = $user_group");

              foreach ($groups_result as $grows) 
                      {
  
                      $user_group = $grows['id'];
                      $group_name = $grows['group_name'];
                      }
             $sectors_result = $db->selectData("sectors","sector_id = $sector");

              foreach ($sectors_result as $srows) 
                      {
  
                      $sector = $srows['sector_id'];
                      $sector_name = $srows['sector'];
                      }
//If the form wasn't submitted, or didn't validate
//then we show the registration form again
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
		<center><h3 class="page-title">My Profile</h3></center>
	       <hr size="1" color="#CCCCCC">
		   <div class="profile-data" align="left">
	<?php echo $message; ?>

	<form action="" method="post">
	
      <div class="labelsDiv">First name: <?php echo $firstname; ?></div><br clear="all">
	<div class="labelsDiv">Last Name: <?php echo $lastname; ?></div><br clear="all">
	<div class="labelsDiv">Username: <?php echo $username; ?></div><br clear="all">
	<div class="labelsDiv">E-Mail:<?php echo $email; ?></div>
	<br clear="all">
	<div class="labelsDiv">user Group: <?php echo $group_name; ?></div><br clear="all">
	<div class="labelsDiv">Sector:<?php echo $sector_name; ?></div><br clear="all">
	<div class="">Mobile phone:<?php echo $mobile_phone; ?></div><br clear="all">
	
	<div class="labelsDiv"> <a href="editprofile.php">Edit Details</a></div>
	
	</form>
</div><br clear="all">
</center>
	    </div> 		
	 	
 <?php
 include "includes/footer.php"; 
 ?>