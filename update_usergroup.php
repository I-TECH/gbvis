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
	$group_id = $_POST['group_id'];
	$group_name = $_POST['group_name'];
	$description = $_POST['description'];

	//initialize variables for form validation
	
	
	    //prep the data for saving in a new user object
	    $data['group_name'] = $group_name;
		 $data['description'] = $description;
		 $data['created'] = $date_created;
	
	    //create the new user object
	    $newUsergroup = new DB ($data);
	
	    //save the new user group to the database
	    
		$data = array(
				"group_name" => "'$group_name'",
				"description" => "'$description'",
				"created" => "'$date_created'"
		);
	    $id = $db->update($data, "user_groups","id = $group_id");
	  
	   $msg = "Group updated successfully <br/> \n\r";
	

	
	    //save the new user to the database
	    
	    
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