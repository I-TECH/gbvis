 <?php
           $Logged_user =$user->username;
            $user_sector_name= $user->sector;
            $user_email=$user->email;
            $Logged_user_group =$user->user_group;
            
            $group_results = $db->selectData("user_groups","id = $Logged_user_group");

              foreach ($group_results as $urows) 
                      {
  
                      $Logged_user_group = $urows['id'];
                      $Logged_group = $urows['group_name'];
                      }
             $sector_results = $db->selectData("sectors","sector_id = $user_sector_name");

              foreach ($sector_results as $urows) 
                      {
  
                      $user_sector_name = $urows['sector_id'];
                      $user_sector = $urows['sector'];
                      }
              ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo $current_page;?></title>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<META NAME="DESCRIPTION" CONTENT="">
<META NAME="KEYWORDS" CONTENT="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../UI/css/style.css" rel="stylesheet" type="text/css">
<link href="../../UI/css/style2.css" rel="stylesheet" type="text/css">
<link href="../../UI/css/popupcss.css" rel="stylesheet" type="text/css">
<link href="../../UI/css/popup.css" rel="stylesheet" type="text/css">
<link href="../../UI/css/modal.css" rel="stylesheet" type="text/css">
<link href="../../UI/css/bootstrap/bootstrap.css" rel="stylesheet" media="screen"/>
<script src="../../UI/css/bootstrap/bootstrap-tab.js" type="text/javascript" ></script>
 <link rel="stylesheet" href="/js/jquery-ui-1.11.2.custom/jquery-ui.css">
<script src="../../UI/js/jquery-ui-1.11.2.custom/jquery-1.10.2.js"></script>
<script src="../../UI/js/jquery-ui-1.11.2.custom//jquery-ui.js"></script>
<script language="javascript" src="json2.js"></script>
<script language="javascript" src="./js/update_aggregates.js"></script>
<script language="javascript" src="./js/police.js"></script>

<script>
$(function() {
$( "#accordion" ).accordion();
});
</script>
</head>

<body >
<div id="gbiv-wrapper">
<div id="header">
   <div class="logo">
      <img src="images/logo.png" height="70" /> 
	</div>
    <div class="menuLinks">
	  <div class="top-menuLinks">
	   <div class="system-title">
	  <h3 class="title-name">Gender Based Violence Information System(GBVIS)</h3>
      </div>
	  <div class="user_status_nav">
	    <section class="login-status-sec">
         
		<font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white;padding-right:2px;"> Welcome <?php echo $Logged_user ?></font>|
		<font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white;padding-right:2px;"><?php echo $Logged_group ?></font>|
		<font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white;padding-right:2px;"><?php echo $user_sector ?></font>|
           <a href="../../profile.php" align="left" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white; text-decoration:none;padding-right:2px;padding-left:2px;">Profile</a>|
            <a href="../../logout.php" align="left" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white; text-decoration:none;padding-right:2px;">Log Out</a>
			
	   </section>
	</div>
	</div>
	<div class="bottom-menuLinks">
	<!--menu here-->
	</div>
	 </div>
 </div>
 <div id="gbvis-main">