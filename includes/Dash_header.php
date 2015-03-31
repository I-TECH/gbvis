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
<META NAME="DESCRIPTION" CONTENT="">
<META NAME="KEYWORDS" CONTENT="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/style2.css" rel="stylesheet" type="text/css">
<link href="css/login_style.css" rel="stylesheet" type="text/css">
<link href="css/popupcss.css" rel="stylesheet" type="text/css">
<link href="css/popup.css" rel="stylesheet" type="text/css">
<link href="css/modal.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap/bootstrap.css" rel="stylesheet" media="screen"/>
<script src="css/bootstrap/bootstrap-tab.js" type="text/javascript" ></script>
 <link rel="stylesheet" href="/js/jquery-ui-1.11.2.custom/jquery-ui.css">
<script src="js/jquery-ui-1.11.2.custom/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.11.2.custom//jquery-ui.js"></script>
<script language="javascript" src="./js/aggregates.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {

    // Radialize the colors
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });

    // Build the chart
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Prosecuted of SGBV cases, Jan-March 2015'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: [
                ['Convicted',   14.0],
                ['Withdrawn',       32.0],
                {
                    name: 'Unresolved',
                    y: 52.0,
                    sliced: true,
                    selected: true
                }
            ]
        }]
    });
});


		</script>
</head>

<body>
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
         
		<font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white;padding-right:2px;"> Welcome <?php echo  $user->username;?></font>|
		<font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white;padding-right:2px;"> <?php echo $Logged_group; ?></font>|
		<font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white;padding-right:2px;"> <?php echo $user_sector; ?></font>|
           <a href="profile.php" align="left" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white; text-decoration:none;padding-right:2px;padding-left:2px;">Profile</a>|
            <a href="logout.php" align="left" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white; text-decoration:none;padding-right:2px;">Log Out</a>
			
	   </section>
	</div>
	</div>
	<div class="bottom-menuLinks">
	<!--menu here-->
	</div>
	 </div>
 </div>
 <div id="gbvis-main">