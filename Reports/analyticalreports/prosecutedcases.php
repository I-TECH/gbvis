<?php  $page_title = "Analytical Reports | GBV";
    $current_page = "Analytical Reports";
	
require_once '../includes/globallevel2.inc.php';


 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);


include "../includes/pie_header2.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;  font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	  include "../includes/sidebarlevel2.php"; 
	  ?>
	</div> 
	  </div> 
	  <div id="main-content_with_side_bar">
	    <div id="bread-crumbs">
	      <!--breadcrumbs-->
	    </div>
        <div id="content-body">
	<h3 class="page-title">Analytical reports</h3>
	<hr size="1" color="#CCCCCC">       
 <div class="profile-data" align="left">
 
<script src="../Highcharts/js/highcharts.js"></script>
<script src="../Highcharts/js/modules/data.js"></script>
<script src="../Highcharts/js/modules/drilldown.js"></script>

<div id="container" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->

<pre id="tsv" style="display:none">Browser Version prosecuted cases
<?php 
//include "classes/DB.class.php";
$db = new DB();
$db->connect();
$csv= $db->selectAll("piechart_drilldown"); 
echo  $csv;
?>
</pre>
 <center><div><section style="float:left; margin-left:25px;"><a href="../analytical_reports.php" align="left" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; color:#81519C; text-decoration:none;padding-right:2px;">Back to Reports</a></section> <section style="float:right; margin-right:10px;"> <a href="" align="left" style="font-family:Verdana, Geneva, sans-serif; font-size:15px; color:#81519C; text-decoration:none;padding-right:2px;">Print</a></section></div> 

	</div>
<br clear="all">

	    </div> 		

	 </div> 	 
 <?php
 include "../../includes/footer.php"; 
	}
else
{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../../login.php");
}
?>
