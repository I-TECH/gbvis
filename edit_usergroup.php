<?php 
//index.php
  $page_title = "Create Users | GBV";
    $current_page = "Create Users";
	


require_once 'includes/global.inc.php';
require_once('classes/dropdown.class.php');

if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);

//initialize php variables used in the form
$group_name = "";
$description = "";
$error = "";

$usergroup_id = $_GET['id'];

$get_usergroup = $db->selectData("user_groups"," id = $usergroup_id");

foreach ($get_usergroup as $urows) 
{
  
  $group_id = $urows['id'];
  $group_name = $urows['group_name'];
  $description = $urows['description'];
}


//If the form wasn't submitted, or didn't validate
//then we show the registration form again

include "includes/header.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px; font-family: TStar-Bol"></h3></center>
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
		<h3 class="page-title">Edit users</h3>
	       <hr size="1" color="#CCCCCC">
  <div class="profile-data" align="left"> 

<table class="forms-table" width="700" style="">
   <form method="post" action="update_usergroup.php">
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">View User Group</td></tr>
</tr>
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;"><p id="msgDsp" STYLE="color:#FF0000; font-size:14px; "></p>
</td></tr>
</tr>
<tr>
<td width="50%" class="table-td-input">Group  ID</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="group_id" id="lastname" value="<?php echo $group_id; ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Group  Name</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="group_name" id="lastname" value="<?php echo $group_name; ?>" class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Description</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="description" id="lastname" value="<?php echo $description; ?>"  class=form_textbox_inputs></div></td>
</tr>
<tr>
<td class="table-td-label"></td>

<td width="50%" style=" padding:5px;">

<input type="submit" onClick="" value=Save name="submit-form" class="gbvis_general_button">
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
	header("Location: login.php");
}
?>