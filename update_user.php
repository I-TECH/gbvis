<?php 

  $page_title = "Add Aggreagtes| GBV";
    $current_page = "Update Aggreagtes";

require_once 'includes/global.inc.php';
//require_once('classes/dropdown.class.php');

if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);
$sectorname = $user->sector;
//initialize php variables used in the form


$msg="";

//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables

	$date_created=date("Y-m-d");
	$userid = $_POST['userid'];
	$username = $_POST['username'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$user_group = $_POST['user_group'];
	$sector = $_POST['sector'];
	$password = $_POST['password'];
	$password_confirm = $_POST['password-confirm'];
	$email = $_POST['email'];
	$mobile_phone = $_POST['mobile_phone'];
	$password = $_POST['password'];
	

	//initialize variables for form validation
	  
	    //prep the data for saving in a new user object
	    
	    $data['firstname'] = $firstname;
	    $data['lastname'] = $lastname;
	    $data['username'] = $username;
	    $data['user_group'] = $user_group;
	    $data['password'] = md5($password); //encrypt the password for storage
	    $data['email'] = $email;
	    $data['mobile_phone'] = $mobile_phone;
	    $data['sector'] = $sector;
	    $data['password'] = $password;
	    //$data['join_date'] = $date_modified;
	
	    //create the new user object
	  
	      $data = array(
			      "firstname" => "'$firstname'",
				"lastname" => "'$lastname'",
				"username" => "'$username'",
				"user_group" => "$user_group",
				"password" => "'$password'",
				"email" => "'$email'",
				"mobile_phone" => "'$mobile_phone'",
				"sector" => "'$sector'",
				//"join_date" => "'$this->date'"
				
			);
			
			//update the row in the database
			$db->update($data, "users", "id = $userid");
			
	
	   
	    $msg = "User details updated successfully <br/> \n\r";
	    
	}

//check to see that the form has been submitted

//If the form wasn't submitted, or didn't validate
//then we show the registration form again

include "includes/header.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;   font-family: TStar-Bol"></h3></center>
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
		<h3 class="page-title">Edit indicators</h3>
	       <hr size="1" color="#CCCCCC">
    <div class="profile-data" align="left">
	<?php echo ($msg != "") ? $msg : ""; ?>
	<br clear="all">
     <a href="users_accounts.php">Back to users</a>

<br clear="all"><br clear="all"><br clear="all">

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