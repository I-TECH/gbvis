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
//check to see that the form has been submitted
if(isset($_POST['submit-settings'])) { 

	//retrieve the $_POST variables
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$mobile_phone = $_POST['mobile_phone'];
	$email = $_POST['email'];
	
	$user->firstname= $firstname;
	$user->lastname = $lastname;
	$user->email = $email;
	$user->mobile_phone = $mobile_phone;
	$user->save();

	$message = "Profile Updated successfully <br/>";
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
		<center><h3 class="page-title">Edit profile</h3></center>
	       <hr size="1" color="#CCCCCC">
		   <div class="profile-data" align="left">
	<div><p style="font-family:Verdana, Geneva, sans-serif; font-size:145px; color:red;padding-left:25px"><?php echo $message; ?></p></p></p></div>

	<form action="" method="post" >
	
	<div class="labelsDiv">First name:</div>
       <div class="inputsDiv"> <input type="text" value="<?php echo $firstname; ?>" name="firstname" class="textInputs" /></div><br clear="all">

	<div class="labelsDiv">Last Name:</div>
       <div class="inputsDiv"> <input type="text" value="<?php echo $lastname; ?>" name="lastname" class="textInputs" /></div><br clear="all">
       
	<div class="labelsDiv">Username: </div>
       <div class="inputsDiv"><input type="text" value="<?php echo $username; ?>" name="username" readonly class="textInputs" /></div><br clear="all">
       
	<div class="labelsDiv">E-Mail:</div>
       <div class="inputsDiv"> <input type="text" value="<?php echo $email; ?>" name="email" class="textInputs" /></div><br clear="all">
       
	<div class="labelsDiv">user Group: </div>
       <div class="inputsDiv"><input type="text" value="<?php echo $group_name; ?>" readonly name="user_group" class="textInputs" /></div><br clear="all">
       
	<div class="labelsDiv">Sector: </div>
       <div class="inputsDiv"><input type="text" value="<?php echo $sector_name; ?>" readonly name="sector" class="textInputs"/></div><br clear="all">
       
	<div class="labelsDiv">Mobile phone: </div>
       <div class="inputsDiv"><input type="text" value="<?php echo $mobile_phone; ?>" name="mobile_phone" class="textInputs"/></div><br clear="all">
      <br clear="all">
	
	<div class="labelsDiv"></div>
       <div class="inputsDiv"><input type="submit" value="Update" name="submit-settings" class="login_button" /></div>
	<br clear="all">
	<br clear="all">
	</form>
	<br clear="all">
	<br clear="all">
</div><br clear="all">
<br clear="all">
</center>
	    </div> 		
	 	
 <?php
 include "includes/footer.php"; 
 ?>