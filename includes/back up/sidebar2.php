<?php
/*********************************************************************
* This script has been released with the aim that it will be useful.
* Author: Benard Koech
* Email: benardkkoech@gmail.com.
* Gender Base violence Information system
***********************************************************************/



//Include the database connection file
?>
<!-- Below is how you can perform your users access level activities -->
      <?php
      if($user->user_group == 0) //Show only the logout link to users whose Access Level is at 0
      {
	   ?>
	   <h3 style="text-size:18px;  font-family: TStar-Bol">Home</h3>
	   <ul>
	   <li><a href="index.php" style="text-decoration:none;">Home</a><li>
	   <li><a href="profile.php" style="text-decoration:none;">Profile</a><li>
	   <li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
       </ul>
	   <?php
     }
     else if($user->user_group  == 1) //Show both the logout link and the link to enter admin panel to users whose Access Level is at 1
     {
	?>
	<h3 style="text-size:18px;  font-family: TStar-Bol">Administrator Panel</h3>
	<ul> 
	 <li><a href="index.php" style="text-decoration:none;">Home</a><li>
    <li><a href="users_accounts.php" style="text-decoration:none;">Users Accounts</a></li>
	<li><a href="" style="text-decoration:none;">Settings</a></li>
	<li><a href="" style="text-decoration:none;">Imports</a></li>
	<li><a href="sectors.php" style="text-decoration:none;">Sectors</a></li>
	<li><a href="indicators.php" style="text-decoration:none;">Indicators</a></li>
	<li><a href="" style="text-decoration:none;">Approvals</a></li>
	<li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
    </ul>
	<?php
    }
	 else if($user->user_group  == 2) //Show both the logout link and the link to enter admin panel to users whose Access Level is at 1
     {
	?>
	<h3 style="text-size:18px;  font-family: TStar-Bol">Data Admin</h3>
	<ul> 
   <li><a href="index.php" style="text-decoration:none;">Home</a><li>
     <li><a href="Judiciary/aggregates.php" style="text-decoration:none;">Aggregates</a></li>
    <li><a href="Judiciary/indicators.php" style="text-decoration:none;">Indicators</a></li>
  <li><a href="Judiciary/import_files.php" style="text-decoration:none;">Import</a></li>
    <li><a href="Judiciary/Upload_excel/data_approval.php" style="text-decoration:none;">Approvals</a></li>
   <li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
    </ul>
	<?php
    }
     else
    {
	//Do not show any thing because this user's access level is unknown which is not possible in this system or just show the logout button here
     }
     ?>
