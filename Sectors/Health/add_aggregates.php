<?php 

  $page_title = "Add Aggreagtes| GBV";
    $current_page = "Add Aggregates";

require_once 'includes/global.inc.php';
require_once('../../classes/dropdown.class.php');

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
$gender = "";
$age_range = "";
$sector = "";
$date_recorded = "";
$Added = false;


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
<td width="50%" class="table-td-input">Age</td>
<?php


$ddl=new dropdown();

?>
<td width="50%" class="table-td-input"><div id='s3'><?php $ddl->dropdown('age_range'); ?></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Gender</td>
<td width="50%" class="table-td-input"><div id='s2'>
<select name="gender"  required class="gbvis_select">
    		<option value="">Select Gender</option>
    		<option value="male" name="male">Male</option>
    		<option value="female" name="female">Female</option>
    	
 </select>
</div></td>
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