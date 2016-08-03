

<?php
//index.php
  $page_title = "Analytical Reports | GBV";
    $current_page = "Analytical Reports";
	
require_once '../../../includes/globallevel3.inc.php';


 //check to see if they're logged in
if(isset($_SESSION['logged_in'])) {

//get the user object from the session
$user = unserialize($_SESSION['user']);


include "../../../includes/headerlevel3.php"; 
?>
	  <div id="sidebar">
	  <center><h3 style="text-size:18px;  font-family: TStar-Bol"></h3></center>
	<div class="sidebar-nav">
	<?php
	  include "../../../includes/sidebarlevel3.php"; 
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
	
<script src="../../js/highcharts.js"></script>
<script src="../../js/modules/data.js"></script>
<script src="../../js/modules/drilldown.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsv" style="display:none">Browser Version	Total Market Share
number of police trained EMBU	100.00
number of police trained MERU	150.00
number of police trained MOMBASA	75.00
number of cases reported EMBU	50.00
number of cases reported MERU	80.00
number of cases reported MOMBASA	60.00
number of judges trained EMBU	100.00
number of judges trained MERU	150.00
number of judges trained MOMBASA	75.00
number of prosecutors trained EMBU	100.00
number of prosecutors trained MERU	150.00
number of prosecutors trained MOMBASA	75.00
number of prosecutors trained GARISSA	300.00
number of prosecutors trained WAJIR	350.00
</pre>

	</div>
<br clear="all">

	    </div> 		

	 </div> 	 
 <?php
 include "../../../includes/footer.php"; 
	}
else
{
	//Redirect user back to login page if there is no valid session created
	header("Location: ../../../../login.php");
}
?>
