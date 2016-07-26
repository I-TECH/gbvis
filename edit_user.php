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
$userid="";

$userid =$_GET["id"];

$get_user = $db->selectData("users"," id = $userid");

foreach ($get_user as $urows) 
{
  
  $userid= $urows['id'];
  $firstname = $urows['firstname'];
  $lastname = $urows['lastname'];
  $username = $urows['username'];
  $email = $urows['email'];
  $mobile_phone = $urows['mobile_phone'];
  $sector = $urows['sector'];
  $user_group = $urows['user_group'];


}



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
	  <div id="main-content_with_side_bar">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
		<h3 class="page-title">Edit users</h3>
	       <hr size="1" color="#CCCCCC">
  <div class="profile-data" align="left"> 

<table class="forms-table" width="700" style="">
   <form method="post" action="update_user.php">
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">Eidt User</td></tr>
</tr>
<tr>
<td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;"><p id="msgDsp" STYLE="color:#FF0000; font-size:14px; "></p>
</td></tr>
</tr>
<tr>
<td width="50%" class="table-td-input">User ID</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="userid" id="lastname" value="<?php echo $userid; ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">First Name</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="firstname" id="lastname" value="<?php echo $firstname; ?>" class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Last Name</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>" class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">User name</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="username" id="username" value="<?php echo $username; ?>" readonly class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Email</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="email" id="email" value="<?php echo $email; ?>" class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Mobile Phone No</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="text" name="mobile_phone" id="mobile_phone" value="<?php echo $mobile_phone; ?>" class=form_textbox_inputs></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">User group</td>
<?php


$ddl=new dropdown();

?>
<td width="50%" class="table-td-input"><div id='s2'><?php $ddl->dropdown('user_groups'); ?></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Sectors</td>
<?php


$ddl=new dropdown();

?>
<td width="50%" class="table-td-input"><div id='s3'><?php $ddl->dropdown('sectors'); ?></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Password</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="password" name="password" id="password" value="" class="form_textbox_inputs"></div></td>
</tr>
<tr>
<td width="50%" class="table-td-input">Confirm password</td>
<td width="50%" class="table-td-input"><div id='t1'><input type="password" name="password-confirm" id="password-confirm" value="" class="form_textbox_inputs"></div></td>
</tr>
<tr>
<td class="table-td-label"></td>

<td width="50%" style=" padding:5px;">

<input type="submit"  value=Save name="submit-form" class="gbvis_general_button">
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
