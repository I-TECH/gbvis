<?php
/*********************************************************************
* This script has been released with the aim that it will be useful.
* Author: Benard Koech
* Email: benardkkoech@gmail.com.
* Gender Base violence Information system
***********************************************************************/

/*TA:60:1*/


$db = new DB();
$group_results = $db->selectData("user_groups","id = $user->user_group");
$sector_results = $db->selectData("sectors","sector_id = $user->sector");

$APP_WEB_ROOT_PATH = "http://" . $_SERVER['HTTP_HOST'] . '/' . explode('/', $_SERVER['SCRIPT_NAME'])[1];

//Include the database connection file
?>
<!-- Below is how you can perform your users access level activities -->
      <?php
	
     if($userTools->isSuperAdmin($user->user_group)){ //Show  enter admin panel to users whose Access Level is at super admin
	?>
	<!-- TA:60:1 -->
	<ul class="meganizr mzr-class mzr-slide mzr-responsive">
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/index.php">Home</a></li>
	   <!-- TA:60:1 we do not know if we need to add here 
	   <li class="mzr-drop">
	   <a href="#">Admin Panel</a>
	   <ul>
	   <li><a href="users_accounts.php">Users Accounts</a></li>
	    <li><a href="survey_periods.php">Survey periods</a></li>
	    <li><a href="sectors.php">Sectors</a></li>
	    <li><a href="indicators.php">Indicators</a></li>
	    <li><a href="aggregates.php">Aggregates</a></li>
	    <li><a href="Data_uploadandapproval/import_files.php">Import</a></li>
	    <li><a href="Data_uploadandapproval/data_approval.php">File Approvals</a></li>
	   </ul>
	   </li>
	   -->
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/enter_data.php">Data</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/Reports/">View Reports</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/help.php">Help</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/logout.php">Log out</a></li>
	   <li class="mzr-align-right"><a href="<?php echo $APP_WEB_ROOT_PATH;?>/profile.php">Manage Account</a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $group_results[0]['group_name']?$group_results[0]['group_name']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href="">Welcome <?php echo  $user->username;?></a></li>
       </ul>
	<?php
         }else if($userTools->isAdmin($user->user_group)){ //Show both the logout link and the link to enter admin panel to users whose Access Level is at 1
            if($userTools->health($user->sector)){
        ?>
	<ul class="meganizr mzr-class mzr-slide mzr-responsive">
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/index.php">Home</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/enter_data.php">Data</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/Reports/">View Reports</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/help.php">Help</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/logout.php">Log out</a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $sector_results[0]['sector']?$sector_results[0]['sector']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $group_results[0]['group_name']?$group_results[0]['group_name']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href="">Welcome <?php echo  $user->username;?></a></li>
       </ul>
	<?php
	}else  if($userTools->judiciary($user->sector)) {
		?>
	<ul class="meganizr mzr-class mzr-slide mzr-responsive">
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/index.php">Home</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/enter_data.php">Data</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/Reports/">View Reports</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/help.php">Help</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/logout.php">Log out</a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $sector_results[0]['sector']?$sector_results[0]['sector']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $group_results[0]['group_name']?$group_results[0]['group_name']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href="">Welcome <?php echo  $user->username;?></a></li>
       </ul>
	<?php
	}else if($userTools->prosection($user->sector)) {
		?>
	<ul class="meganizr mzr-class mzr-slide mzr-responsive">
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/index.php">Home</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/enter_data.php">Data</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/Reports/">View Reports</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/help.php">Help</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/logout.php">Log out</a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $sector_results[0]['sector']?$sector_results[0]['sector']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $group_results[0]['group_name']?$group_results[0]['group_name']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href="">Welcome <?php echo  $user->username;?></a></li>
       </ul>
	<?php
	}else if($userTools->police($user->sector)) {
		?>
	<ul class="meganizr mzr-class mzr-slide mzr-responsive">
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/index.php">Home</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/enter_data.php">Data</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/Reports/">View Reports</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/help.php">Help</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/logout.php">Log out</a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $sector_results[0]['sector']?$sector_results[0]['sector']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $group_results[0]['group_name']?$group_results[0]['group_name']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href="">Welcome <?php echo  $user->username;?></a></li>
       </ul>
	<?php
	}else if($userTools->community($user->sector)) {
		?>
	<ul class="meganizr mzr-class mzr-slide mzr-responsive">
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/index.php">Home</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/enter_data.php">Data</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/Reports/">View Reports</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/help.php">Help</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/logout.php">Log out</a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $sector_results[0]['sector']?$sector_results[0]['sector']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $group_results[0]['group_name']?$group_results[0]['group_name']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href="">Welcome <?php echo  $user->username;?></a></li>
       </ul>
	<?php	
		}else if($userTools->education($user->sector)) {
		?>
	<ul class="meganizr mzr-class mzr-slide mzr-responsive">
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/index.php">Home</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/enter_data.php">Data</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/Reports/">View Reports</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/help.php">Help</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/logout.php">Log out</a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $sector_results[0]['sector']?$sector_results[0]['sector']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $group_results[0]['group_name']?$group_results[0]['group_name']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href="">Welcome <?php echo  $user->username;?></a></li>
       </ul>
	<?php	
		}else if($userTools->social_services($user->sector)) {
		?>
	<ul class="meganizr mzr-class mzr-slide mzr-responsive">
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/index.php">Home</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/enter_data.php">Data</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/Reports/">View Reports</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/help.php">Help</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/logout.php">Log out</a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $sector_results[0]['sector']?$sector_results[0]['sector']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $group_results[0]['group_name']?$group_results[0]['group_name']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href="">Welcome <?php echo  $user->username;?></a></li>
       </ul>
	<?php
		}else  {
	      ?>
	 <ul class="meganizr mzr-class mzr-slide mzr-responsive">
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/index.php">Home</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/enter_data.php">Data</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/Reports/">View Reports</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/help.php">Help</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/logout.php">Log out</a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $sector_results[0]['sector']?$sector_results[0]['sector']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $group_results[0]['group_name']?$group_results[0]['group_name']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href="">Welcome <?php echo  $user->username;?></a></li>
       </ul>
	<?php
	     }
       }else if($userTools->isGuest($user->user_group)){ //Show only the logout link to users whose Access Level is at is guest
      //TA:60:1
	   ?>
	   <ul class="meganizr mzr-class mzr-slide mzr-responsive">
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/index.php">Home</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/enter_data.php">Data</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/Reports/">View Reports</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/help.php">Help</a></li>
	   <li><a href="<?php echo $APP_WEB_ROOT_PATH;?>/logout.php">Log out</a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $sector_results[0]['sector']?$sector_results[0]['sector']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href=""><?php echo $group_results[0]['group_name']?$group_results[0]['group_name']:'';?></a></li>
	   <li class="mzr-align-right"><a style="pointer-events: none; cursor: default;" href="">Welcome <?php echo  $user->username;?></a></li>
       </ul>
	   <?php
     } else{
	//Do not show any thing because this user's access level is unknown which is not possible in this system or just show the logout button here
     }
     ?>
