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
	   <ul>
	   <li><a href="../../../../index.php" style="text-decoration:none;">Home</a><li>
	   <li><a href="../../../../profile.php" style="text-decoration:none;">Profile</a><li>
	   <li><a href="../../../../Reports/" style="text-decoration:none;">Reports</a></li>
       </ul>
	   <?php
     }
      else if($userTools->isSuperAdmin($user->user_group))  //Show both the logout link and the link to enter admin panel to users whose Access Level is at 1
     {
	?>
		<h3 style="text-size:18px;  font-family: TStar-Bol">Reports</h3>
	<ul> 
   <li><a href="../../../../index.php" style="text-decoration:none;">Home</a><li>
    <li><a href="../../../stardard_reports.php" style="text-decoration:none;">Standard Reports</a></li>
    <li><a href="../../../analytical_reports.php" style="text-decoration:none;">Analytical Reports</a></li>
      <li><a href="" style="text-decoration:none;">Periodical reports</a></li>
	  <li><a href="" style="text-decoration:none;">Progress Reports</a></li>
    </ul>
	<?php
    }
	 else if($userTools->isAdmin($user->user_group))  //Show both the logout link and the link to enter admin panel to users whose Access Level is at 1
     {
	?>
	<h3 style="text-size:18px;  font-family: TStar-Bol">Reports</h3>
	<ul> 
   <li><a href="../../../../index.php" style="text-decoration:none;">Home</a><li>
    <li><a href="../../../stardard_reports.php" style="text-decoration:none;">Standard Reports</a></li>
    <li><a href="../../../analytical_reports.php" style="text-decoration:none;">Analytical Reports</a></li>
      <li><a href="" style="text-decoration:none;">Periodical reports</a></li>
	  <li><a href="" style="text-decoration:none;">Progress Reports</a></li>
    </ul>
	<?php
    }
     else
    {
	//Do not show any thing because this user's access level is unknown which is not possible in this system or just show the logout button here
     }
     ?>
