<?php 

  $page_title = "Add Aggreagtes| GBV";
    $current_page = "Reject File";

require_once '../includes/globallevel2.inc.php';
//require_once('../classes/dropdown.class.php');

if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);
$sectorname = $user->sector;
//initialize php variables used in the form

$Upload_id="";

$msg="";

//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables

	$date_created=date("Y-m-d");
	$status = "Rejected";
	$Upload_id= $_POST['Upload_id'];
	$rejection_reason= $_POST['rejection_reason'];
	

	//initialize variables for form validation
	  
	    //prep the data for saving in a new user object
	    
	    //prep the data for saving in a new user object
                       
                        $data['status'] = $status;
		        $data['rejection_reason'] = $rejection_reason;
		        //$data['date'] = $date;
	
	             //create the new file upload object
	           $newUpload = new DB ($data);
	          
	        //save the new file upload to the database
	    
		    $data = array (
		 		"status" => "'$status'",
				"rejection_reason" => "'$rejection_reason'",
				//"date" => "'$date'"
		              );
	           $id = $newUpload->update($data, "file_uploads"," id = $Upload_id");
	   
	    $msg = "Rejected reason updated successfully <br/> \n\r";
	    
	}

//check to see that the form has been submitted

//If the form wasn't submitted, or didn't validate
//then we show the registration form again

include "../includes/headerlevel2.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;   font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	   include "../includes/sidebarlevel2.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content_with_side_bar">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
		<h3 class="page-title">Edit indicators</h3>
	       <hr size="1" color="#CCCCCC">
    <div class="profile-data" align="left">
	<?php echo ($msg != "") ? $msg : ""; ?>
	<br clear="all">
     <a href="data_approval.php">Back to file Approvals</a>

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