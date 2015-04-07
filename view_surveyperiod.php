<?php 

  $page_title = "View Surveys| GBV";
    $current_page = "View Surveys";

require_once 'includes/global.inc.php';


if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);
//initialize php variables used in the form

$msg = "";
$survey_id = "";
$indicator_id = "";
$indicator = "";
$survey = "";
$Added = false;

$survey_id = $_GET['id'];

$survey_results = $db->selectData("surveys"," survey_id = $survey_id");

foreach ($survey_results as $crows) 
{
  
  $survey_id = $crows['survey_id'];
  $survey_name = $crows['survey'];
  
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
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">View surveys</td></tr>
</tr>
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;"><p id="msgDsp" STYLE="color:#FF0000; font-size:14px; "></p>
</td></tr>
</tr>
<tr>
<td width="50%" class="table-td-input">survey ID</td>
<td width="50%" class="table-td-input"><div id='s3'><div id='t1'><input type=text name=survey_id value="<?php echo $survey_id ?>" readonly  class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">survey</td>
<td width="50%" class="table-td-input"><div id='t1'><input type=text name=survey value="<?php echo $survey_name ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td class="table-td-label"></td>

<td width="50%" style=" padding:5px;"> <a href="survey_periods.php">Back to surveys</a></td>
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