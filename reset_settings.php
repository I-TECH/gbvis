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
if(isset($_POST['submit-settings'])) { 

	//retrieve the $_POST variables
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$mobile_phone = $_POST['mobile_phone'];
	$sector = $_POST['sector'];
	$user_group = $_POST['user_group'];
	$email = $_POST['email'];
	
	$user->firstname= $firstname;
	$user->lastname = $lastname;
	$user->email = $email;
	$user->mobile_phone = $mobile_phone;
	$user->sector = $sector;
	$user->user_group = $user_group;
	$user->save();

	$message = "Settings Saved<br/>";
}

//If the form wasn't submitted, or didn't validate
//then we show the registration form again
include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;  font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	  include "includes/sidebar.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content_with_side_bar">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
		<center><h3 class="page-title">Edit profile</h3></center>
	       <hr size="1" color="#CCCCCC">
		   <div class="profile-data" align="left">
	<?php echo $message; ?>

	<form action="" method="post">
	
	<div class="labelsDiv">First name:</div>
       <div class="inputsDiv"> <input type="text" value="<?php echo $firstname; ?>" name="firstname" /></div>
	<div class="labelsDiv">Last Name:</div>
       <div class="inputsDiv"> <input type="text" value="<?php echo $lastname; ?>" name="lastname" /></div>
	<div class="labelsDiv">Username: </div>
       <div class="inputsDiv"><input type="text" value="<?php echo $username; ?>" name="username" /></div>
	<div class="labelsDiv">E-Mail:</div>
       <div class="inputsDiv"> <input type="text" value="<?php echo $email; ?>" name="email" /></div>
	<div class="labelsDiv">user Group: </div>
       <div class="inputsDiv"><input type="text" value="<?php echo $user_group; ?>" name="user_group" /></div>
	<div class="labelsDiv">Sector: </div>
       <div class="inputsDiv"><input type="text" value="<?php echo $sector; ?>" name="sector" /></div>
	<div class="labelsDiv">Mobile phone: </div>
       <div class="inputsDiv"><input type="text" value="<?php echo $mobile_phone; ?>" name="mobile_phone" /></div>
	
	<div class="labelsDiv"></div>
       <div class="inputsDiv"><input type="submit" value="Update" name="submit-settings" /></div>
	
	</form>
</div><br clear="all">
</center>
	    </div> 		
	 	
 <?php
 include "includes/footer.php"; 
 ?>