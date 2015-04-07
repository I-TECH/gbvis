<?php 
//index.php
  $page_title = "Create Users | GBV";
    $current_page = "Create Users";
	


require_once '../includes/globallevel2.inc.php';
require_once('../classes/dropdown.class.php');

if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);

//initialize php variables used in the form
$name = "";
$size= "";
$type= "";
$uploadedby= "";
$sector = "";
$description = "";
$useremail = "";
$status = "";
$error = ""; 
$reason_rejected="";

$Upload_id = $_GET['id'];

$upload = $db->selectData("file_uploads"," id = $Upload_id");

foreach ($upload as $urows) 
{
  
  $Upload_id = $urows['id'];
  $fileName = $urows['name'];
  $uploadedby = $urows['uploadedby'];
  $uploaderemail = $urows['useremail'];
  $file_sector = $urows['sector'];
  $path = $urows['path'];

}



//If the form wasn't submitted, or didn't validate
//then we show the registration form again

include "../includes/headerlevel2.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px; font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	  include "../includes/sidebarlevel2.php"; 
	  
	  ?>
	</div> 
	  </div> 
	  <div id="main-content">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
		<h3 class="page-title">Reject File Import</h3>
	       <hr size="1" color="#CCCCCC">
  <div class="profile-data" align="left"> 

<table class="forms-table" width="700" style="">
   <form method="post" action="reject_reason.php">
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">Rejection Reason</td></tr>
</tr>
</tr>
<tr>
<td width="50%" class="table-td-input">File ID</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="Upload_id" id="Upload_id" value="<?php echo $Upload_id; ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Enter Rejection Reason</td>
<td width="50%" class="table-td-input"><div id='t1'><textarea type="text" name="rejection_reason" id="rejection_reason" style="height: 114px; width: 224px;"  value="" class=form_textbox_inputs></textarea></div></td>
</tr>
<tr>
<td class="table-td-label"></td>
<td width="50%" style=" padding:5px;">
<input type="submit"  value=Reject name="submit-form" class="gbvis_general_button">
<input type="reset" name="Reset" id="" value="Reset" style="" class="gbvis_general_button">
</td>
</tr>
</form>
</table>


<br clear="all">

<br clear="all">
</div><br clear="all">
</center>
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