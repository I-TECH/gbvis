<?php
/*********************************************************************
* This script has been released with the aim that it will be useful.
* Author: Benard Koech
* Email: benardkkoech@gmail.com.
* Gender Base violence Information system
***********************************************************************/

/*TA:60:1*/


//Include the database connection file

      
     if($userTools->isSuperAdmin($user->user_group)){ //Show  enter admin panel to users whose Access Level is at super admin
	?>
	<!-- TA:60:1 -->
	<br clear="all">
	   <br><br><br>
	   <ul>
	   <li><a href="Reports/">Reports</a></li>
	   <li><a href="export_data.php">Export Data</a></li>
	   <li><a href="profile.php">Manage Account</a></li>
       </ul>
       
	<br clear="all">
	<h3 style="text-size:18px;  font-family: TStar-Bol">Admin Panel</h3>
	<ul> 
    <li><a href="users_accounts.php" style="text-decoration:none;">Users Accounts</a></li>
    <li><a href="survey_periods.php" style="text-decoration:none;">Survey periods</a></li>
	<li><a href="sectors.php" style="text-decoration:none;">Sectors</a></li>
	<li><a href="indicators.php" style="text-decoration:none;">Indicators</a></li>
	<li><a href="aggregates.php" style="text-decoration:none;">Aggregates</a></li>
        <li><a href="Data_uploadandapproval/import_files.php" style="text-decoration:none;">Import</a></li>
        <li><a href="Data_uploadandapproval/data_approval.php" style="text-decoration:none;">File Approvals</a></li>
    </ul>
	<?php
         }
	 else if($userTools->isAdmin($user->user_group)){ //Show both the logout link and the link to enter admin panel to users whose Access Level is at 1
         if($userTools->health($user->sector)){
        
	?>
	 <br><br><br>
	   <ul>
	   <li><a href="Reports/">Reports</a></li>
	   <li><a href="enter_data.php">Enter Data</a></li>
	   <li><a href="export_data.php">Export Data</a></li>
	    <li><a href="profile.php">Manage Account</a></li>
       </ul>
	<?php
	}else  if($userTools->judiciary($user->sector)) {
		?>
		<!-- TA:60:1 -->
	<br clear="all">
	   <br><br><br>
	   <ul>
	   <li><a href="Reports/">Reports</a></li>
	   <li><a href="enter_data.php">Enter Data</a></li>
	   <li><a href="export_data.php">Export Data</a></li>
	    <li><a href="profile.php">Manage Account</a></li>
	  
       </ul>
	<?php
		
		}
	else if($userTools->prosection($user->sector)) 
		{
		?>
		<!-- TA:60:1 -->
	<br clear="all">
	   <br><br><br>
	   <ul>
	   <li><a href="Reports/">Reports</a></li>
	   <li><a href="enter_data.php">Enter Data</a></li>
	   <li><a href="export_data.php">Export Data</a></li>
	    <li><a href="profile.php">Manage Account</a></li>
	   
       </ul>
	
	<?php
		
		}
		else if($userTools->police($user->sector)) {
		?>
		<!-- TA:60:1 -->
	<br clear="all">
	   <br><br><br>
	   <ul>
	   <li><a href="Reports/">Reports</a></li>
	   <li><a href="enter_data.php">Enter Data</a></li>
	   <li><a href="export_data.php">Export Data</a></li>
	    <li><a href="profile.php">Manage Account</a></li>
	  
       </ul>
       
	
	<?php
		
		}
		else if($userTools->community($user->sector)) {
		?>
		<!-- TA:60:1 -->
	<br clear="all">
	   <br><br><br>
	   <ul>
	   <li><a href="Reports/">Reports</a></li>
	   <li><a href="enter_data.php">Enter Data</a></li>
	   <li><a href="export_data.php">Export Data</a></li>
	    <li><a href="profile.php">Manage Account</a></li>
	   
       </ul>
       
	<br clear="all">
	<!--  <h3 style="text-size:18px;  font-family: TStar-Bol"> Admin Police</h3>
	<ul> 
        <li><a href="Sectors/Community/aggregates.php" style="text-decoration:none;">Aggregates</a></li>
        <li><a href="Sectors/Community/indicators.php" style="text-decoration:none;">Indicators</a></li>
        <li><a href="Sectors/Community/import_files.php" style="text-decoration:none;">Import</a></li>
        </ul>-->
	<?php
		
		}else if($userTools->education($user->sector)) {
		?>
		
		<!-- TA:60:1 -->
	<br clear="all">
	   <br><br><br>
	   <ul>
	   <li><a href="Reports/">Reports</a></li>
	   <li><a href="enter_data.php">Enter Data</a></li>
	   <li><a href="export_data.php">Export Data</a></li>
	    <li><a href="profile.php">Manage Account</a></li>
	  
       </ul>
   
	<?php
		
		}
		else if($userTools->social_services($user->sector)) {
		?>
		<!-- TA:60:1 -->
	<br clear="all">
	   <br><br><br>
	   <ul>
	   <li><a href="Reports/">Reports</a></li>
	   <li><a href="enter_data.php">Enter Data</a></li>
	   <li><a href="export_data.php">Export Data</a></li>
	    <li><a href="profile.php">Manage Account</a></li>
	  
       </ul>
       
	
	<?php
		
		}
	else  {
	      ?>
	      <!-- TA:60:1 -->
	<br clear="all">
	   <br><br><br>
	   <h3 style="text-size:18px;  font-family: TStar-Bol">Guest</h3>
	   <ul>
	   <li><a href="Reports/">Reports</a></li>
	   
	    
	  
       </ul>
  
	<?php
	
	     }
       }
    else if($userTools->isGuest($user->user_group)){ //Show only the logout link to users whose Access Level is at is guest
 //TA:60:1
	   ?>
	   <br clear="all">
	   <br><br><br>
	   <ul>
	   <li><a href="Reports/">Reports</a></li>
	    <li><a href="profile.php">Manage Account</a></li>
       </ul>
	   <?php
     }
     else
     {
	//Do not show any thing because this user's access level is unknown which is not possible in this system or just show the logout button here
     }
     ?>
