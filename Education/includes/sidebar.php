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
      
     if($userTools->isGuest($user->user_group))//Show the home and reports links to users whose Access Level is Guest
      {
	   ?>
	   <br clear="all">
	   <h3 style="text-size:18px;  font-family: TStar-Bol">Guest</h3>
	   <ul>
	   <li><a href="../index.php" style="text-decoration:none;">Home</a><li>
	   <li><a href="../profile.php" style="text-decoration:none;">Profile</a><li>
	   <li><a href="../Reports/" style="text-decoration:none;">Reports</a></li>
       </ul>
	   <?php
     }
     else if($userTools->isSuperAdmin($user->user_group)) //Show  the link to enter admin panel to users whose Access Level is atSI SuperAdmin
     {
	?>
	<br clear="all">
	<h3 style="text-size:18px;  font-family: TStar-Bol">Judiciary Admin</h3>
	<ul> 
	 <li><a href="../index.php" style="text-decoration:none;">Home</a><li>
   <li><a href="../dashboard.php" style="text-decoration:none;">Admin Panel</a></li>
    <li><a href="../users_accounts.php" style="text-decoration:none;">Users Accounts</a></li>
	<li><a href="" style="text-decoration:none;">Settings</a></li> 
	<li><a href="aggregates.php" style="text-decoration:none;">Aggregates</a></li>
         <li><a href="indicators.php" style="text-decoration:none;">Indicators</a></li>
         <li><a href="import_files.php" style="text-decoration:none;">Import</a></li>
	  <li><a href="../Reports/" style="text-decoration:none;">Reports</a></li>
    </ul>
	<?php
         }
	 else if($userTools->isAdmin($user->user_group)) //Show  the link to enter admin panel to users whose Access Level is at ISAdmin
        {
	?>
	<br clear="all">
	<h3 style="text-size:18px;  font-family: TStar-Bol">Admin Panel</h3>
	<ul> 
            <li><a href="index.php" style="text-decoration:none;">Home</a><li>
            <li><a href="aggregates.php" style="text-decoration:none;">Aggregates</a></li>
            <li><a href="indicators.php" style="text-decoration:none;">Indicators</a></li>
            <li><a href="import_files.php" style="text-decoration:none;">Import</a></li>
	    <li><a href="../Reports/" style="text-decoration:none;">Reports</a></li>
    </ul>
	<?php
    }
     else
    {
	//Do not show any thing because this user's access level is unknown which is not possible in this system or just show the logout button here
     }
     ?>
