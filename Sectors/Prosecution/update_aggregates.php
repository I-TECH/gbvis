<?php 

  $page_title = "Add Aggreagtes| GBV";
    $current_page = "Update Aggreagtes";

require_once 'includes/global.inc.php';
require_once('../../classes/dropdown.class.php');

if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);
$sectorname = $user->sector;
//initialize php variables used in the form


$msg="";

if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables
	$date_created=date("Y-m-d");
	$aggregate = $_POST['aggregates'];
	$aggregate_id = $_POST['aggregate_id'];
	

	//initialize variables for form validation
	$success = true;
	$db = new DB();
	
	
	if($success)
	{
	    //prep the data for saving in a new user object
	    $data['aggregate'] = $aggregate;
	    //$data['created'] = $date_created;
	
	    //create the new user object
	    $newUsergroup = new DB ($data);
	
	    //save the new user group to the database
	    
		$data = array(
		"aggregate" => "'$aggregate'",
				//"created" => "'$date_created'"
		);
	    $id = $db->update($data, "prosecution_aggregates","id = $aggregate_id");
	  
	    $msg="Record Updated successfully";
	}

}
//check to see that the form has been submitted

//If the form wasn't submitted, or didn't validate
//then we show the registration form again

include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;   font-family: TStar-Bol"></h3></center>
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
		<h3 class="page-title">Edit Aggregates</h3>
	       <hr size="1" color="#CCCCCC">
    <div class="profile-data" align="left">
	<?php echo ($msg != "") ? $msg : ""; ?>
	<br clear="all">
     <a href="aggregates.php">Back to Aggregates</a>

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
	header("Location: ../../login.php");
}
?>