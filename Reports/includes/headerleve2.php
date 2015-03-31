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
<link href="../../css/style.css" rel="stylesheet" type="text/css">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<link href="../../css/popupcss.css" rel="stylesheet" type="text/css">
<link href="../../css/modal.css" rel="stylesheet" type="text/css">
<link href="../../css/bootstrap/bootstrap.css" rel="stylesheet" media="screen"/>
<script src="../../css/bootstrap/bootstrap-tab.js" type="text/javascript" ></script>
 <link rel="../../stylesheet" href="/js/jquery-ui-1.11.2.custom/jquery-ui.css">
<script src="../../js/jquery-ui-1.11.2.custom/jquery-1.10.2.js"></script>
<script src="../js/../jquery-ui-1.11.2.custom//jquery-ui.js"></script>
 <link rel="stylesheet" type="text/css" href="../../css/datepicker/datepickr.min.css">
 <link rel="stylesheet" type="text/css" href="../../css/datepicker/datepickr.css">
 <script src="../../css/datepicker/datepickr.css"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		
		<script type="text/javascript">
$(function () {

    Highcharts.data({
        csv: document.getElementById('tsv').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {

            var brands = {},
                brandsData = [],
                versions = {},
                drilldownSeries = [];

            // Parse percentage strings
            columns[1] = $.map(columns[1], function (value) {
                if (value.indexOf('%') === value.length - 1) {
                    value = parseFloat(value);
                }
                return value;
            });

            $.each(columns[0], function (i, name) {
                var brand,
                    version;

                if (i > 0) {

                    // Remove special edition notes
                    //name = name.split(' -')[0];

                    // Split into brand and version
                    version = name.match(/([A-Z]+[\.]*)/);
                    if (version) {
					//alert(version);
                        version = version[0];
                    }
                    brand = name.replace(version,'');

                    // Create the main data
                    if (!brands[brand]) {
                        brands[brand] = columns[1][i];
                    } else {
                        brands[brand] += columns[1][i];
                    }

                    // Create the version data
                    if (version !== null) {
                        if (!versions[brand]) {
                            versions[brand] = [];
                        }
                        versions[brand].push([version, columns[1][i]]);
                    }
                }

            });

            $.each(brands, function (name, y) {
                brandsData.push({
                    name: name,
                    y: y,
                    drilldown: versions[name] ? name : null
                });
            });
            $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });

            // Create the chart
            $('#container').highcharts({
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Total SGBV cases. Feb, 2015.'
                },
                subtitle: {
                    text: 'Click the slices to view proportions of SGBV cases that were withdrawn,convicted or unresolved.'
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}: {point.y:.1f}%'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                },

                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: brandsData
                }],
                drilldown: {
                    series: drilldownSeries
                }
            });
        }
    });
});


		</script>
</head>

<body >
<div id="gbiv-wrapper">
<div id="header">
   <div class="logo">
      <img src="../../images/logo.png" height="70" /> 
	</div>
    <div class="menuLinks">
	  <div class="top-menuLinks">
	   <div class="system-title">
	  <h3 class="title-name">Gender Based Violence Information System(GBVIS)</h3>
      </div>
	  <div class="user_status_nav">
	    <section class="login-status-sec">
		<font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white;padding-right:2px;"> Welcome <?php echo $user->username; ?></font>|
		<font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white;padding-right:2px;"> <?php echo $Logged_group; ?></font>|
		<font style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:white;padding-right:2px;"> <?php echo $user_sector; ?></font>|
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