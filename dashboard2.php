 
 <?php
//index.php
  $page_title = Dashboard  | GBV";
    $current_page = "Dashboard";
	

session_start();
ob_start();

//Include the database connection file
include "includes/database_connection.php"; 

//Check to be sure that a valid session has been created
if(isset($_SESSION["VALID_USER_ID"]))
{
	
	//Check the database table for the logged in user information
	$check_user_details = mysql_query("select * from `users` where `username` = '".mysql_real_escape_string($_SESSION["VALID_USER_ID"])."'");
	//Validate created session
	if(mysql_num_rows($check_user_details) < 1)
	{
		session_unset();
		session_destroy();
		header("location: login.php");
	}
	else
	{
	//Get all the logged in user information from the database users table
	$get_user_details = mysql_fetch_array($check_user_details);
	$user_id = strip_tags($get_user_details['id']);
	$fullname = strip_tags($get_user_details['fullname']);
	$username = strip_tags($get_user_details['username']);
	$email = strip_tags($get_user_details['email']);
	$user_access_level = strip_tags($get_user_details['user_levels']);
	$passwd = strip_tags($get_user_details['password']);

 include "includes/header.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;  font-family: TStar-Bol"></h3></center>
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
		<center><h3 class="page-title">Create users</h3></center>
	       
		   <div class="profile-data" align="left">
         <div style="width:220px;padding:8px;padding-bottom:13px;float:left; background:#F1F1F1;" align="left">Fullname</div><div style="width:220px;padding:8px;padding-bottom:13px;float:left;background:#F1F1F1;" align="left">Username</div><div style="width:252px;padding:8px;padding-bottom:13px;float:left;background:#F1F1F1;" align="left">Email Address</div><br clear="all" /><br clear="all" />

         <div style="padding:8px; float:left; cursor:pointer;" class="vasplus_live_edit_area" align="left">

      <div style="width:236px;float:left;">
       <?php echo $fullname; ?>

</div>

<div style="width:236px;float:left;">
<?php echo $username; ?>

</div>


<div style="width:240px;float:left;">
<?php echo $email; ?>
</div>
</div>

<br clear="all">
<hr size="1" color="#CCCCCC">


<br clear="all">
</div><br clear="all">

	    </div> 		
	  </div> 	
 <?php
 include "includes/footer.php"; 
	}
}
else
{
	//Redirect user back to login page if there is no valid session created
	header("location: login.php");
}
?>