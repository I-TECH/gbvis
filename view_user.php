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
$fullname = "";
$username = "";
$password = "";
$user_group= "";
$password_confirm = "";
$email = "";
$error = "";

$user_id = $_GET['id'];

$get_user = $db->selectData("users"," id = $user_id");

foreach ($get_user as $urows) 
{
  
  $user_id = $urows['id'];
  $firstname = $urows['firstname'];
  $lastname = $urows['lastname'];
  $username = $urows['username'];
  $email = $urows['email'];
  $mobile_phone = $urows['mobile_phone'];
  $sector = $urows['sector'];
  $user_group = $urows['user_group'];


}
       $groups_result = $db->selectData("user_groups","id = $user_group");

              foreach ($groups_result as $grows) 
                      {
  
                      $user_group = $grows['id'];
                      $group_name = $grows['group_name'];
                      }
             $sectors_result = $db->selectData("sectors","sector_id = $sector");

              foreach ($sectors_result as $srows) 
                      {
  
                      $sector = $srows['sector_id'];
                      $sector_name = $srows['sector'];
                      }
        
//check to see that the form has been submitted


//If the form wasn't submitted, or didn't validate
//then we show the registration form again

//include "includes/header.php"; 
include "includes/Dash_header.php"; 
include "includes/topbar.php"; //TA:60:1
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
		<h3 class="page-title">View user</h3>
	       <hr size="1" color="#CCCCCC">
  <div class="profile-data" align="left"> 

<table class="forms-table" width="700" style="">
   <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;"><p >View User </p></td></tr>
</tr>
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;"><p style="float:right; font-size:15px;">  <a href="users_accounts.php">Back to users</a></p><p id="msgDsp" STYLE="color:#FF0000; font-size:14px; "></p>
</td></tr>
</tr>
<tr>
<td width="50%" class="table-td-input">First Name</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="lastname" id="lastname" value="<?php echo $firstname; ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Last Name</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>" readonly  class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">User name</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="username" id="username" value="<?php echo $username; ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Email</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="email" id="email" value="<?php echo $email; ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Mobile Phone No</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="mobile_phone" id="mobile_phone" value="<?php echo $mobile_phone; ?>" readonly  class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">User group</td>

<td width="50%" class="table-td-input"><div id='s2'><input type="text" name="mobile_phone" id="mobile_phone" value="<?php echo $group_name; ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Sectors</td>
<td width="50%" class="table-td-input"><div id='s3'><input type="text" name="mobile_phone" id="mobile_phone" value="<?php echo $user_sector; ?>" readonly class=form_textbox_inputs></div></td>
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
