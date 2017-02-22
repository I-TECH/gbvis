<?php 

  $page_title = "Add Aggreagtes| GBV";
    $current_page = "Add Aggreagtes";

require_once 'includes/global.inc.php';
require_once('classes/dropdown.class.php');

if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);
$sectorname = $user->sector;
//initialize php variables used in the form

$msg = "";
$county_id = "";
$survey_id = "";
$indicator_id = "";
$aggregates = "";
$sector_id = "";
$date_recorded = "";
$Added = false;


//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	$date_recorded = date("Y-m-d");
	$county_id  = $_POST['county'];
	$sector_id  = $_POST['sector'];
	$survey_id  = $_POST['survey'];
	$indicator_id = $_POST['indicator'];
	$aggregates = $_POST['aggregates'];
	
	

	//initialize variables for form validation
	$success = true;
	$db = new DB();
	 
	 //validate that the form was filled out correctly
	//check to see if user name already exists
	
	if($success)
	{
	
	$Added=false;
	
	    //prep the data for saving in a new user object
	    $data['sector_id'] = $sector_id;
	    $data['county_id'] = $county_id;
	    $data['indicator_id'] = $indicator_id;
	    $data['survey_id'] = $survey_id;
	    $data['aggregate'] = $aggregates;
	    $data['date'] = $date_recorded;
		 
	
	    //create the new indicator object
	    $Jud_indicators = new DB ($data);
	
	    //save the new user group to the database
	    
		$data = array(
				"sector_id" => "'$sector_id'",
				"county_id" => "'$county_id'",
				"indicator_id"=> "'$indicator_id'",
				"survey_id"=> "'$survey_id'",
				"aggregate"=> "'$aggregates'",
				"date"=> "'$date_recorded'"
				
		);
	    $id = $db->insert($data, 'judiciary_aggregates');
	    
	  $Added = true;
	  
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
		<h3 class="page-title">Add Aggreagtes</h3>
	       <hr size="1" color="#CCCCCC">
    <div class="profile-data" align="left">
	<?php echo ($msg != "") ? $msg : ""; ?>
	      
 <table class="forms-table" width="700" style="">
  <form  name="myForm">
  

<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">Add Aggregates</td></tr>
</tr>
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;"><p id="msgDsp" STYLE="color:#FF0000; font-size:14px; "></p>
</td></tr>
</tr>
<tr>
<td width="50%" class="table-td-input">Sector</td>
<?php


$ddl=new dropdown();

?>
<td width="50%" class="table-td-input"><div id='s1'><?php $ddl->dropdown('sectors'); ?></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Counties</td>
<?php


$ddl=new dropdown();

?>
<td width="50%" class="table-td-input"><div id='s1'><?php $ddl->dropdown('counties'); ?></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Survey Period</td>
<?php


$ddl=new dropdown();

?>
<td width="50%" class="table-td-input"><div id='s2'><?php $ddl->dropdown('surveys'); ?></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Indicator</td>
<?php


$ddl=new dropdown();

?>
<td width="50%" class="table-td-input"><div id='s3'><?php $ddl->dropdown('indicators'); ?></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Aggregates</td>
<td width="50%" class="table-td-input"><div id='t1'><input type=text name=aggregates class=form_textbox_inputs></div></td>
</tr>
<tr>
<td class="table-td-label"></td>

<td width="50%" style=" padding:5px;"><input type=button onClick=ajaxFunction() value=Save class=gbvis_general_button></td>
</tr>
</form>
</table>
<br clear="all">
<hr size="1" color="#CCCCCC">
<br clear="all"><br clear="all"><br clear="all">
<?php
if($Added){
echo "<script type='text/javascript'>alert('Record Added successfully!')</script>";
}
?>
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