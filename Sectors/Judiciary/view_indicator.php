<?php 

  $page_title = "Add Aggreagtes| GBV";
    $current_page = "Add Aggreagtes";

require_once 'includes/global.inc.php';
require_once('../../classes/dropdown.class.php');

if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);
$sectorname = $user->sector;
//initialize php variables used in the form

$msg = "";
$indicator_id = "";
$indicator = "";


$indicator_id = $_GET['id'];

$indicator_results = $db->selectData("indicators"," indicator_id = $indicator_id");

foreach ($indicator_results as $irows) 
{
  
  $indicator_id = $irows['indicator_id'];
  $indicator = $irows['indicator'];
 
  
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
		<h3 class="page-title">View Indicator</h3>
	       <hr size="1" color="#CCCCCC">
    <div class="profile-data" align="left">
	<?php echo ($msg != "") ? $msg : ""; ?>
	      
 <table class="forms-table" width="700" style="">
  <form  name="myForm" method="post" action="update_indicator.php" >
  

<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">View indicator</td></tr>
</tr>
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;"><p id="msgDsp" STYLE="color:#FF0000; font-size:14px; "></p>
</td>
</tr>
<tr>
<td width="50%" class="table-td-input">ID</td>
<td width="50%" class="table-td-input"><div id='s1'><input type=text name=indicator_id value="<?php echo $indicator_id ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Indicator</td>
<td width="50%" class="table-td-input"><div id='s3'><div id='t1'><textarea type=text name=indicator style="height:140px; width:230px;" readonly class=form_textbox_inputs><?php echo $indicator ?> </textarea></div></td>
</tr>
<tr>
<td class="table-td-label"></td>
<td width="50%" style=" padding:5px;"><a href="indicators.php">Back to Indicators</a></td>
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