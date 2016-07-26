<?php
/*********************************************************************
* Author: Benard Koech
* Email: benardkkoech@gmail.com.
* Gender Base violence Information system
***********************************************************************/
session_start();
ob_start();

//Include the database connection file
include "/includes/database_connection.php"; 
$tabActive = 'tab1';
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
	
	 include "/includes/header.php";
?>

	    <div id="sidebar">
	  <center><h3 style="text-size:18px;  background:#DDCF0D;  color:#81519C; font-family: TStar-Bol">Side Bar</h3></center>
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
		
        <div class="" align="left">
              <div class="tabbable" >
                  <ul class="nav nav-tabs">
                   <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Users</a></li>
                    <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">User Groups</a></li>
                    
                  </ul>
				<div class="tab-content" style="min-height: 350px ">
                    <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
		<center><h3 class="page-title">Users</h3></center>
		<section class="" style="width:85%;">
	       <form action="#">
          <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
          <a class="link-btn" href="add_users.php">Add New User</a>
		   <a class="link-btn" href="export_data.php">Export To Excel</a>
        </form>
		</section>
        <div class="profile-data" align="left">
            <table width="100%" border="1" align="center" cellspacing="1" class="table-hover">
            <thead>
              <th><b>ID</b></th>
			  <th><b>Name</b></th>
			  <th><b>User Name</b></th>
			  <th><b>Email</b></th>
			  <th><b> Created Date</b></th>
              <th><b>View</b></th>
              <th><b>Edit</b></th>
			   <th><b>Delete</b></th>
            </thead>
            <?php
            $result_set = mysql_query("SELECT * FROM users ");
            while ($row = mysql_fetch_array($result_set)) {
                $id = $row['id'];
			  $fullname = $row['fullname'];
			   $user_name = $row['username'];
			    $email = $row['email'];
			  $date = $row['date'];
              ?>
              <tr bgcolor="#FFFFFF" style="border-bottom: 1px solid #B4B5B0;">
                <td><?php echo $id ?></td>
				 <td><?php echo $fullname ?></td>
				  <td><?php echo $user_name ?></td>
				   <td><?php echo $email ?></td>
				<td><?php echo $date ?></td>
                 <td align="center"><a href=''><img src="images/icons/view2.png" height="20px"/><a></td>
				 <td align="center"><a href=''><img src="images/icons/edit2.png" height="20px"/></a></td>
                <td align="center"><a href=''><img src="images/icons/delete.png" height="20px"/></a></td>
              </tr>
            <?php } ?>
          </table>
      <br clear="all"><br clear="all"><br clear="all">
      </div><br clear="all">
	  </div>
       <!--tab 2 ==============================================================================================-->
      <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
          <section class="" style="width:85%;">
		    <center><h3 class="page-title">User Groups</h3></center>
	       <form action="#">
          <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
          <a class="link-btn" href="">Add New Group</a>
        </form>
		</section>
        <div class="profile-data" align="left">
            <table width="100%" border="1" align="center" cellspacing="1" class="table-hover">
            <thead>
              <th><b>ID</b></th>
			  <th><b>User Group</b></th>
			  <th><b>Sector</b></th>
			  <th><b>Description</b></th>
			  <th><b> Created Date</b></th>
              <th><b></b></th>
              <th><b></b></th>
			   <th><b></b></th>
            </thead>
            <?php
            $result_set = mysql_query("SELECT * FROM user_groups ");
            while ($row = mysql_fetch_array($result_set)) {
                $id = $row['id'];
			  $group_name = $row['group_name'];
			   $sector= $row['sector_id'];
			    $description = $row['description'];
			  $date = $row['created'];
			  
			   $results = mysql_query("SELECT * FROM sectors WHERE id='$sector'");
          while ($row = mysql_fetch_array($results)) {
        $sector_id = $row['id'];
        $sector_name = $row['sector'];
		}
              ?>
              <tr bgcolor="#FFFFFF" style="border-bottom: 1px solid #B4B5B0;">
                <td><?php echo $id ?></td>
				 <td><?php echo $group_name ?></td>
				  <td><?php echo $sector_name ?></td>
				   <td><?php echo $description ?></td>
				<td><?php echo $date ?></td>
                <td align="center"><a href=''><img src="images/icons/view2.png" height="20px"/><a></td>
				 <td align="center"><a href=''><img src="images/icons/edit2.png" height="20px"/></a></td>
                <td align="center"><a href=''><img src="images/icons/delete.png" height="20px"/></a></td>
              </tr>
            <?php } ?>
          </table>
      <br clear="all"><br clear="all"><br clear="all">
      </div>
	      </div> 	
		</div> 		
	  </div> 
      </div>
	  <br clear="all">

	    </div> 		
	  </div> 
	
      
<!--filter includes-->
    <script type="text/javascript" src="css/filter-as-you-type/jquery.min.js"></script>
    <script type="text/javascript" src="css/filter-as-you-type/jquery.quicksearch.js"></script>
	<script type="text/javascript" src="js/tab.js"></script>
    <script type="text/javascript">
                $(function() {
                  $('input#id_search').quicksearch('table tbody tr');
                });
    </script>
    <script>
      function show_confirm(member_id) {
        if (confirm("Are you Sure you want to delete?")) {
          location.replace('users_accounts.php?id=' + id);
        } else {
          return false;
        }
      }
    </script>
	
<?php
 include "/includes/footer.php";
	}
}

else
{
	//Redirect user back to login page if there is no valid session created
	header("location: login.php");
}
?>

