<?php 
//index.php
  $page_title = "Add Sector | GBV";
    $current_page = "Add Sector";
	

require_once 'includes/global.inc.php';


if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);

//initialize php variables used in the form

$msg = "";
$id = "";
$sector = "";
$description= "";
//$status = "Not Approved";
$date_recorded = "";


//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables
	$date_recorded = date("Y-m-d");
	$sector = $_POST['sector'];
	//$description  = $_POST['description'];
	//initialize variables for form validation
	$success = true;
	$db = new DB();
	 
	 //validate that the form was filled out correctly
	//check to see if user name already exists
	
	if($success)
	{
	    //prep the data for saving in a new user object
	    $data['sector_id'] = $id;
		 //$data['description'] = $description;
		 $data['sector'] = $sector;
		 // $data['status'] = $status;
		 // $data['date'] = $date_recorded;
		 
	
	    //create the new indicator object
	    $Jud_indicators = new DB ($data);
	
	    //save the new user group to the database
	    
		$data = array(
				"sector_id" => "'$id'",
				//"description" => "'$description'",
				"sector" => "'$sector'",
				//"status" => "'$status'",
				//"date"=> "'$date_recorded'"
				
		);
	    $id = $db->insert($data, 'sectors');
	  
	   $msg .= "Record added successfully <br/> \n\r";
	}

}

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
	<h3 class="page-title">Add Sector</h3>
	       
    <div class="profile-data" align="left">
	<?php echo ($msg != "") ? $msg : ""; ?>
	      
 <table class="forms-table" width="700" style="">
  <form action="#tab3" method="post" enctype="multipart/form-data">

<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">Add Indicators</td></tr>
</tr>
<tr>
<td wwidth="50%" colspan="2" class="table-td-label"><center>Sector</center></td></tr>
<tr>
<td width="50%" class="table-td-label">Sector</td>
<td width="50%" class="table-td-input"><textarea type="text" name="sector" id="sector" style="height:50px;" class="form_textbox_inputs"></textarea></td>
</tr>
<tr>
<!--<td width="50%" class="table-td-input">Description</td>
<td width="50%" class="table-td-input"><textarea type="text" name="description" id="description" style="height:50px;" class="form_textbox_inputs"></textarea></td>
</tr>-->
<tr>
<td class="table-td-label"></td>
<td width="50%" style=" padding:5px;"><input type="submit" name="submit-form" value="SAVE" class="gbvis_general_button" /></td>
</tr>
</form>

</table>
<br clear="all">
<hr size="1" color="#CCCCCC">
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