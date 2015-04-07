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
	
     if($userTools->isSuperAdmin($user->user_group)) //Show  enter admin panel to users whose Access Level is at super admin
     {
	?>
	<br clear="all">
	<h3 style="text-size:18px;  font-family: TStar-Bol">Admin Panel</h3>
	<ul> 
	 <li><a href="index.php" style="text-decoration:none;">Home</a><li>
    <li><a href="users_accounts.php" style="text-decoration:none;">Users Accounts</a></li>
    <li><a href="survey_periods.php" style="text-decoration:none;">Survey periods</a></li>
	<li><a href="sectors.php" style="text-decoration:none;">Sectors</a></li>
	<li><a href="indicators.php" style="text-decoration:none;">Indicators</a></li>
	<li><a href="aggregates.php" style="text-decoration:none;">Aggregates</a></li>
        <li><a href="Data_uploadandapproval/import_files.php" style="text-decoration:none;">Import</a></li>
        <li><a href="Data_uploadandapproval/data_approval.php" style="text-decoration:none;">File Approvals</a></li>
        <li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
    </ul>
	<?php
         }
	 else if($userTools->isAdmin($user->user_group)) //Show both the logout link and the link to enter admin panel to users whose Access Level is at 1
        {
         if($userTools->health($user->sector)){
        
	?>
	<br clear="all">
	<h3 style="text-size:18px;  font-family: TStar-Bol"> Admin Health</h3>
	<ul> 
        <li><a href="index.php" style="text-decoration:none;">Home</a><li>
        <li><a href="Sectors/Health/aggregates.php" style="text-decoration:none;">Aggregates</a></li>
        <li><a href="Sectors/Health/indicators.php" style="text-decoration:none;">Indicators</a></li>
        <li><a href="Sectors/Health/import_files.php" style="text-decoration:none;">Import</a></li>
        <li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
        </ul>
	<?php
	}
	else  if($userTools->judiciary($user->sector)) 
		{
		?>
	<br clear="all">
	<h3 style="text-size:18px;  font-family: TStar-Bol"> Admin Judiciary</h3>
	<ul> 
        <li><a href="index.php" style="text-decoration:none;">Home</a><li>
        <li><a href="Sectors/Judiciary/aggregates.php" style="text-decoration:none;">Aggregates</a></li>
        <li><a href="Sectors/Judiciary/indicators.php" style="text-decoration:none;">Indicators</a></li>
        <li><a href="Sectors/Judiciary/import_files.php" style="text-decoration:none;">Import</a></li>
        <li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
        </ul>
	<?php
		
		}
	else if($userTools->prosection($user->sector)) 
		{
		?>
	<br clear="all">
	<h3 style="text-size:18px;  font-family: TStar-Bol"> Admin Prosecution</h3>
	<ul> 
        <li><a href="index.php" style="text-decoration:none;">Home</a><li>
        <li><a href="Sectors/Prosecution/aggregates.php" style="text-decoration:none;">Aggregates</a></li>
        <li><a href="Sectors/Prosecution/indicators.php" style="text-decoration:none;">Indicators</a></li>
        <li><a href="Sectors/Prosecution/import_files.php" style="text-decoration:none;">Import</a></li>
        <li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
        </ul>
	<?php
		
		}
		else if($userTools->police($user->sector)) 
		{
		?>
	<br clear="all">
	<h3 style="text-size:18px;  font-family: TStar-Bol"> Admin Police</h3>
	<ul> 
        <li><a href="index.php" style="text-decoration:none;">Home</a><li>
        <li><a href="Sectors/Police/aggregates.php" style="text-decoration:none;">Aggregates</a></li>
        <li><a href="Sectors/Policen/indicators.php" style="text-decoration:none;">Indicators</a></li>
        <li><a href="Sectors/Police/import_files.php" style="text-decoration:none;">Import</a></li>
        <li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
        </ul>
	<?php
		
		}
		else if($userTools->community($user->sector)) 
		{
		?>
	<br clear="all">
	<h3 style="text-size:18px;  font-family: TStar-Bol"> Admin Police</h3>
	<ul> 
        <li><a href="index.php" style="text-decoration:none;">Home</a><li>
        <li><a href="Sectors/Community/aggregates.php" style="text-decoration:none;">Aggregates</a></li>
        <li><a href="Sectors/Community/indicators.php" style="text-decoration:none;">Indicators</a></li>
        <li><a href="Sectors/Community/import_files.php" style="text-decoration:none;">Import</a></li>
        <li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
        </ul>
	<?php
		
		}
		else if($userTools->education($user->sector)) 
		{
		?>
	<br clear="all">
	<h3 style="text-size:18px;  font-family: TStar-Bol"> Admin Police</h3>
	<ul> 
        <li><a href="index.php" style="text-decoration:none;">Home</a><li>
        <li><a href="Sectors/Education/aggregates.php" style="text-decoration:none;">Aggregates</a></li>
        <li><a href="Sectors/EducationProsectution/indicators.php" style="text-decoration:none;">Indicators</a></li>
        <li><a href="Sectors/EducationProsectution/import_files.php" style="text-decoration:none;">Import</a></li>
        <li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
        </ul>
	<?php
		
		}
		else if($userTools->social_services($user->sector)) 
		{
		?>
	<br clear="all">
	<h3 style="text-size:18px;  font-family: TStar-Bol"> Admin Police</h3>
	<ul> 
        <li><a href="index.php" style="text-decoration:none;">Home</a><li>
        <li><a href="Sectors/Social_Services/aggregates.php" style="text-decoration:none;">Aggregates</a></li>
        <li><a href="Sectors/Social_Services/indicators.php" style="text-decoration:none;">Indicators</a></li>
        <li><a href="Sectors/Social_Services/import_files.php" style="text-decoration:none;">Import</a></li>
        <li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
        </ul>
	<?php
		
		}
	else  {
	      ?>
	 <br clear="all">
	   <h3 style="text-size:18px;  font-family: TStar-Bol">Guest</h3>
	   <ul>
	   <li><a href="index.php" style="text-decoration:none;">Home</a><li>
	   <li><a href="profile.php" style="text-decoration:none;">Profile</a><li>
	   <li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
       </ul>
	<?php
	
	     }
       }
    else if($userTools->isGuest($user->user_group)) //Show only the logout link to users whose Access Level is at is guest
      {
	 
	   ?>
	   <br clear="all">
	   <h3 style="text-size:18px;  font-family: TStar-Bol">Guest</h3>
	   <ul>
	   <li><a href="index.php" style="text-decoration:none;">Home</a><li>
	   <li><a href="profile.php" style="text-decoration:none;">Profile</a><li>
	   <li><a href="Reports/" style="text-decoration:none;">Reports</a></li>
       </ul>
	   <?php
     }
     else
     {
	//Do not show any thing because this user's access level is unknown which is not possible in this system or just show the logout button here
     }
     ?>
