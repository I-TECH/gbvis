<?php
//index.php
  $page_title = "Home | GBV";
    $current_page = "Home";
	
require_once 'includes/global.inc.php';


 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);


include "includes/Dash_header.php"; 
include "includes/topbar.php"; //TA:60:1

$db = new DB();

$health_aggregates_all = $db->select("health_aggregates", " indicator_id=3 and date >= DATE_SUB(NOW(),INTERVAL 1 YEAR)");
$health_aggregates_total = 0;
$health_male_more18 = 0;
$health_male_less18 = 0;
$health_female_more18 = 0;
$health_female_less18 = 0;
foreach ( $health_aggregates_all as $row ) {
    $health_aggregates_total += $row['aggregate'];
    if($row['gender'] === 'Male' || $row['gender'] === 'male'){
        if($row['age_range'] === '0-11' || $row['age_range'] === '12-17'){
            $health_male_less18 += $row['aggregate'];
        }else{
            $health_male_more18 += $row['aggregate'];
        }
    }else if($row['gender'] === 'Female' || $row['gender'] === 'female'){
        if($row['age_range'] === '0-11' || $row['age_range'] === '12-17'){
            $health_female_less18 += $row['aggregate'];
        }else{
            $health_female_more18 += $row['aggregate'];
        }
    }
}

$result = mysql_query("select counties.county_name, sum(police_aggregates.aggregate) as aggregate from police_aggregates 
    join counties on police_aggregates.county_id=counties.county_id 
    where indicator_id=24 and date >= DATE_SUB(NOW(),INTERVAL 1 YEAR) group by county_name");
$police_aggregates_all=$db->processRowSet($result);

$police_aggregates_total = 0;
foreach ( $police_aggregates_all as $row ) {
    $police_aggregates_total += $row['aggregate'];
}

?>

 <!-- libs to upload chart as PNG-->
    <script type="text/javascript" src="../UI/js/rgbcolor.js"></script> 
<script type="text/javascript" src="../UI/js/canvg.js"></script>
<script type="text/javascript" src="../UI/js/grChartImg.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/data.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/us/us-all.js"></script>


<script type="text/javascript">


google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawPie);
var chart;

function drawPie() {

  var data = google.visualization.arrayToDataTable([
    ['Sector', 'Aggreagates'],
    ['Police',     <?php echo $police_aggregates_total;?>],
    ['Health facilities',      <?php echo $health_aggregates_total;?>],
  ]);

  var options = {
    title: 'Total number of SGBV cases reported'
  };

  chart = new google.visualization.PieChart(document.getElementById('piechart'));
  google.visualization.events.addListener(chart, 'select', getReportBySector);

  chart.draw(data, options);
}

function getReportBySector(){
	var sel_bar = chart.getSelection()[0];
	if(sel_bar.row == '0'){
		
		var data_p = google.visualization.arrayToDataTable([
		                                                  ['county', 'Aggregate'],
		                                                  <?php 
 		                                                  foreach ( $police_aggregates_all as $row ) {
    echo "['" . $row['county_name'] . "'," . $row['aggregate'] . "],";
}
?>
		]);

		var options = {title: 'Total number of SGBV cases reported to the police',
				"legend":"none",
				"width":1000,
        		"height":500,
				hAxis: {slantedText:true, slantedTextAngle:90,showTextEvery:1 }, //lebel vertical view and show all
        		bar: {groupWidth: 20},
        		chartArea : { left: 20, bottom: 80, right:20, height: '57%'} // do not cut off labels
		                                             };

	  var police_chart = new google.visualization.ColumnChart(document.getElementById('police_chart'));
	  police_chart.draw(data_p, options);
	}else{
		var data = google.visualization.arrayToDataTable([
		                                                  ['Group age', 'Male', 'Female'],
		                                                  ['<18 years',     <?php echo $health_male_less18;?>, <?php echo $health_female_less18;?>],
		                                                  ['>18 years',      <?php echo $health_male_more18;?>, <?php echo $health_female_more18;?>],
		                                                ]);

		var options = {title: 'Total number of SGBV cases reported to the Health Facilities',
				vAxis: {minValue:0, maxValue: 5, format: '0'},
				width:550,
				height:500,
		              };

	  var health_chart = new google.visualization.ColumnChart(document.getElementById('health_chart'));
	  health_chart.draw(data, options);
	}
	
}

</script>
	
	  
	  <div id="sidebar">  
	<div class="sidebar-nav">
	<?php
 	  include "includes/sidebar.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content_with_side_bar">
	    
        <div id="content-body">
		<center><h2 class="page-title">Welcome to the National Sexual Gender Violence Information System (GBVIS)</h2></center> <!-- TA:60:1 -->
	      <hr size="1" color="#fff">
	        
		   <div class="profile-data" align="left">
		   
		   <!--  <div id="mapchart" style="width: 650px; height: 500px;"></div>-->

		   
		   <div id="piechart" style="width: 650px; height: 500px;"></div>
		   <div id='health_chart'></div>
		   <div id='police_chart'></div>
				   
          </div>     
       
		   
		   
      <br clear="all">

</div><br clear="all">

	    </div> 		
	 	
 <?php
 include "includes/footer.php"; 
	}else{
	//Redirect user back to login page if there is no valid session created
	header("Location: login.php");
}
?>


