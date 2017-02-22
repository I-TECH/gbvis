<?php 
//register.php

require_once 'includes/global.inc.php';


if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);

//initialize php variables used in the form

$msg = "";
$county_id = "";
$county_name = "";
$SGBV_judges_trained = "";
$SGBV_prosecuted_cases = "";
$SGBV_withdrawn_cases = "";
$SGBV_lodged_cases = "";
$SGBV_disposed_cases = "";
$date_recorded = "";


//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables
	$date_recorded = date("Y-m-d");
	$county_name  = $_POST['county_name'];
	$SGBV_judges_trained  = $_POST['SGBV_judges_trained'];
	$SGBV_prosecuted_cases = $_POST['SGBV_prosecuted_cases'];
	$SGBV_withdrawn_cases = $_POST['SGBV_withdrawn_cases'];
	$SGBV_lodged_cases = $_POST['SGBV_lodged_cases'];
	$SGBV_disposed_cases= $_POST['SGBV_disposed_cases'];
	

	//initialize variables for form validation
	$success = true;
	$db = new DB();
	 
	 //validate that the form was filled out correctly
	//check to see if user name already exists
	
	if($success)
	{
	    //prep the data for saving in a new user object
	    $data['county_id'] = $county_id;
		 $data['county_name'] = $county_name;
		 $data['SGBV_judges_trained'] = $SGBV_judges_trained;
		 $data['SGBV_prosecuted_cases'] = $SGBV_prosecuted_cases;
		 $data['SGBV_withdrawn_cases'] = $SGBV_withdrawn_cases;
		  $data['SGBV_lodged_cases'] = $SGBV_lodged_cases;
		 $data['SGBV_disposed_cases'] = $SGBV_disposed_cases;
		  $data['date_recorded'] = $date_recorded;
		 
	
	    //create the new indicator object
	    $Jud_indicators = new DB ($data);
	
	    //save the new user group to the database
	    
		$data = array(
				"county_id" => "'$county_id'",
				"county_name" => "'$county_name'",
				"SGBV_judges_trained"=> "'$SGBV_judges_trained'",
				"SGBV_prosecuted_cases"=> "'$SGBV_prosecuted_cases'",
				"SGBV_withdrawn_cases"=> "'$SGBV_withdrawn_cases '",
				"SGBV_lodged_cases"=> "'$SGBV_lodged_cases'",
				"SGBV_disposed_cases"=> "'$SGBV_disposed_cases'",
				"date_recorded"=> "'$date_recorded'"
				
		);
	    $id = $db->insert($data, 'judiciary_aggregates');
	  
	   $msg .= "Aggregates added successfully <br/> \n\r";
	}

}

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
		<center><h3 class="page-title">Add Aggregates</h3></center>
	       
    <div class="profile-data" align="left">
	<?php echo ($msg != "") ? $msg : ""; ?>
	      
 <table class="forms-table" width="700" style="">
<div><?php echo  $msg; ?></div>
  <form action="#tab3" method="post" enctype="multipart/form-data">

<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">Add Indicators</td></tr>
</tr>

<tr>
<td width="50%" class="table-td-label" align="left">County</td>
<td width="50%" class="table-td-input"><select type="text" name="county_name" id="county_name" />
<option>Select County</option>
<option>Mombasa</option>
<option>Kisumu</option>
<option>Nairobi</option>
<option>Uasin Gishu</option>
<option>Kericho</option>
</select></td>
</tr>
<tr>
<td width="50%" colspan="2" class="table-td-label"><center>Indicators</center></td></tr>
<tr>
<td width="50%" class="table-td-input">No of judges trained</td>
<td width="50%" class="table-td-input"><input type="text" name="SGBV_judges_trained" id="SGBV_judges_trained" /></td>
</tr>
<tr>
<td width="50%" class="table-td-input">No of procescuted cases</td>
<td width="50%" class="table-td-input"><input type="text" name="SGBV_prosecuted_cases" id="SGBV_prosecuted_cases" /></td>
</tr>
<tr>
<td width="50%" class="table-td-input">No of withdrawn  cases</td>
<td width="50%" class="table-td-input"><input type="text" name="SGBV_withdrawn_cases" id="SGBV_withdrawn_cases" /></td>
</tr>
<tr>
<td width="50%" class="table-td-input">No of lodged cases</td>
<td width="50%" class="table-td-input"><input type="text" name="SGBV_lodged_cases" id="SGBV_lodged_cases" /></td>
</tr>
<tr>
<td width="50%" class="table-td-input">No of Disposed cases</td>
<td width="50%" class="table-td-input"><input type="text" name="SGBV_disposed_cases" id="SGBV_disposed_cases" /></td>
</tr>
<tr>
<td class="table-td-label"></td>
<td width="50%" style=" padding:5px;"><input type="submit" name="submit-form" value="SAVE" /></td>
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
	header("Location: login.php");
}
?>