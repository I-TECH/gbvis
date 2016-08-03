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
$groupname = "";
$description = "";
$error = "";

$usergroup_id = $_GET['id'];

$get_usergroup = $db->selectData("user_groups"," id = $usergroup_id");

foreach ($get_usergroup as $urows) 
{
  
  $user_id = $urows['id'];
  $group_name = $urows['group_name'];
  $description = $urows['description'];


}


include "includes/Dash_header.php";include "includes/topbar.php"; //TA:60:1 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px; font-family: TStar-Bol"></h3></center>
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
		<h3 class="page-title">View user</h3>
	       <hr size="1" color="#CCCCCC">
  <div class="profile-data" align="left"> 

<table class="forms-table" width="700" style="">
   <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">View User Group</td></tr>
</tr>
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;"><p style="float:right; font-size:15px;">  <a href="users_accounts.php">Back to users</a></p><p id="msgDsp" STYLE="color:#FF0000; font-size:14px; "></p>
</td></tr>
</tr>
<tr>
<td width="50%" class="table-td-input">Group  Name</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="group_name" id="lastname" value="<?php echo $group_name; ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Description</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="description" id="lastname" value="<?php echo $description; ?>" readonly  class=form_textbox_inputs></div></td>
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