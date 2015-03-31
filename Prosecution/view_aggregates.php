<?php 

  $page_title = "Add Aggreagtes| GBV";
    $current_page = "Add Aggreagtes";

require_once 'includes/global.inc.php';
require_once('../classes/dropdown.class.php');

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
$sector = "";
$Added = false;

$aggregate_id = $_GET['id'];

$aggr_results = $db->selectData("prosecution_aggregates"," id = $aggregate_id");

foreach ($aggr_results as $urows) 
{
  
  $aggregate_id = $urows['id'];
  $county_id = $urows['county_id'];
  $survey_id = $urows['survey_id'];
  $indicator_id = $urows['indicator_id'];
  $aggregates = $urows['aggregate'];
 
  
}
$indicator_results = $db->selectData("indicators"," indicator_id = $indicator_id");

foreach ($indicator_results as $irows) 
{
  
  $indicator_id = $irows['indicator_id'];
  $indicator = $irows['indicator'];
 
  
}
$county_results = $db->selectData("counties"," county_id = $county_id");

foreach ($county_results as $crows) 
{
  
  $county_id = $crows['county_id'];
  $county_name = $crows['county_name'];
  
}
$surveys_results = $db->selectData("surveys"," survey_id = $survey_id");

foreach ($surveys_results as $srows) 
{
  $survey_id = $srows['survey_id'];
   $survey = $srows['survey'];
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
		<h3 class="page-title">View Aggreagtes</h3>
	       <hr size="1" color="#CCCCCC">
    <div class="profile-data" align="left">
	<?php echo ($msg != "") ? $msg : ""; ?>
	      
 <table class="forms-table" width="700" style="">
  <form  name="myForm">
  

<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">View Aggregates</td></tr>
</tr>
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;"><p id="msgDsp" STYLE="color:#FF0000; font-size:14px; "></p>
</td></tr>
</tr>
<tr>
<td width="50%" class="table-td-input">Counties</td>
<td width="50%" class="table-td-input"><div id='s1'><input type=text name=aggregates value="<?php echo $county_name ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Survey Period</td>
<td width="50%" class="table-td-input"><div id='s2'><input type=text name=survey  value="<?php echo $survey ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Indicator</td>

<td width="50%" class="table-td-input"><div id='s3'><div id='t1'><input type=text name=indicator value="<?php echo $indicator ?>" readonly  class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Aggregates</td>
<td width="50%" class="table-td-input"><div id='t1'><input type=text name=aggregates value="<?php echo $aggregates ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td class="table-td-label"></td>

<td width="50%" style=" padding:5px;"> <a href="aggregates.php">Back to Aggregates</a></td>
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